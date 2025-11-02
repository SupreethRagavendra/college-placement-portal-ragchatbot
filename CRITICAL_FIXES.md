# 🔧 CRITICAL FIXES - Implementation Guide
## Apply These Fixes Immediately

---

## FIX #1: Remove Hardcoded Database Credentials (URGENT!)

### File: `routes/web.php`

**Find (Lines 16-23):**
```php
Route::get('/test-db', function () {
    try {
        $pdo = new PDO(
            "pgsql:host=db.wkqbukidxmzbgwauncrl.supabase.co;port=5432;dbname=postgres;sslmode=require",
            "postgres",
            "Supreeeth24#"
        );
```

**Replace with:**
```php
Route::get('/test-db', function () {
    try {
        $pdo = new PDO(
            sprintf(
                "pgsql:host=%s;port=%d;dbname=%s;sslmode=require",
                config('database.connections.pgsql.host'),
                config('database.connections.pgsql.port'),
                config('database.connections.pgsql.database')
            ),
            config('database.connections.pgsql.username'),
            config('database.connections.pgsql.password')
        );
```

---

## FIX #2: Add Rate Limiting to Authentication

### File: `routes/web.php`

**Find (Lines 106-111):**
```php
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
```

**Replace with:**
```php
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:5,1'); // 5 registrations per minute
    
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1'); // 5 login attempts per minute
});
```

---

## FIX #3: Add Chatbot Rate Limiting

### File: `routes/web.php`

**Find (Around line 190):**
```php
Route::post('/rag-chat', [\App\Http\Controllers\Student\OpenRouterChatbotController::class, 'chat'])->name('student.rag.chat');
```

**Replace with:**
```php
Route::post('/rag-chat', [\App\Http\Controllers\Student\OpenRouterChatbotController::class, 'chat'])
    ->name('student.rag.chat')
    ->middleware('throttle:10,1'); // 10 chatbot questions per minute
```

---

## FIX #4: Fix SQL Injection Risks in whereRaw

### File: `app/Http/Controllers/AdminReportController.php`

**Find (Lines 79-95):**
```php
if ($request->filled('grade')) {
    switch ($request->grade) {
        case 'A':
            $query->whereRaw('(score / total_questions) * 100 >= 90');
            break;
        case 'B':
            $query->whereRaw('(score / total_questions) * 100 >= 80 AND (score / total_questions) * 100 < 90');
            break;
        // ... etc
    }
}
```

**Replace with:**
```php
if ($request->filled('grade')) {
    switch ($request->grade) {
        case 'A':
            $query->whereRaw('(score::float / NULLIF(total_questions, 0)) * 100 >= ?', [90]);
            break;
        case 'B':
            $query->whereRaw('(score::float / NULLIF(total_questions, 0)) * 100 >= ? AND (score::float / NULLIF(total_questions, 0)) * 100 < ?', [80, 90]);
            break;
        case 'C':
            $query->whereRaw('(score::float / NULLIF(total_questions, 0)) * 100 >= ? AND (score::float / NULLIF(total_questions, 0)) * 100 < ?', [70, 80]);
            break;
        case 'D':
            $query->whereRaw('(score::float / NULLIF(total_questions, 0)) * 100 >= ? AND (score::float / NULLIF(total_questions, 0)) * 100 < ?', [60, 70]);
            break;
        case 'F':
            $query->whereRaw('(score::float / NULLIF(total_questions, 0)) * 100 < ?', [60]);
            break;
    }
}
```

---

## FIX #5: Sanitize Search Input

### File: Create new helper method in `app/Http/Controllers/Controller.php`

**Add this method:**
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    /**
     * Sanitize search input to prevent XSS
     */
    protected function sanitizeSearch(string $search): string
    {
        // Remove HTML tags
        $search = strip_tags($search);
        
        // Remove special characters except spaces, hyphens, and underscores
        $search = preg_replace('/[^a-zA-Z0-9\s\-_]/', '', $search);
        
        // Trim and limit length
        $search = trim($search);
        $search = substr($search, 0, 100);
        
        return $search;
    }
}
```

### Then update search implementations:

**File: `app/Http/Controllers/Student/AssessmentController.php`**

**Find (Line 41):**
```php
if ($request->filled('search')) {
    $query->where('title', 'like', '%' . $request->search . '%');
}
```

**Replace with:**
```php
if ($request->filled('search')) {
    $searchTerm = $this->sanitizeSearch($request->search);
    $query->where('title', 'like', '%' . $searchTerm . '%');
}
```

**Repeat for all search implementations in:**
- `app/Http/Controllers/AdminAssessmentController.php`
- `app/Http/Controllers/AdminController.php`
- `app/Http/Controllers/AdminReportController.php`

---

## FIX #6: Fix Session Fixation Vulnerability

### File: `app/Http/Controllers/AuthController.php`

**Find (Lines 105-111):**
```php
if ($this->fastAuthService->authenticate($request)) {
    $user = Auth::user();
    
    if ($this->fastAuthService->canUserLogin($user)) {
        $request->session()->regenerate();
        return $this->redirectToDashboard();
    }
}
```

**Replace with:**
```php
if ($this->fastAuthService->authenticate($request)) {
    // Regenerate session BEFORE login to prevent fixation
    $request->session()->regenerate();
    $request->session()->migrate();
    
    $user = Auth::user();
    
    if ($this->fastAuthService->canUserLogin($user)) {
        return $this->redirectToDashboard();
    }
}
```

---

## FIX #7: Reduce Chatbot Input Length

### File: `app/Http/Controllers/Student/OpenRouterChatbotController.php`

**Find (Line 38-40):**
```php
$request->validate([
    'message' => 'required|string|max:500'
]);
```

**Replace with:**
```php
$request->validate([
    'message' => 'required|string|min:3|max:200' // Reduced from 500 to 200
]);
```

---

## FIX #8: Add Database Transaction for Assessment Submission

### File: `app/Http/Controllers/Student/AssessmentController.php`

**Find the submit method and wrap critical operations:**

**Before:**
```php
public function submit(Request $request, Assessment $assessment)
{
    // ... validation ...
    
    $studentAssessment->update([
        'completed_at' => now(),
        'status' => 'completed'
    ]);
    
    // Calculate scores
    foreach ($answers as $questionId => $answer) {
        // Save answer
    }
    
    StudentResult::create([...]);
}
```

**After:**
```php
public function submit(Request $request, Assessment $assessment)
{
    // ... validation ...
    
    DB::transaction(function () use ($studentAssessment, $answers, $request) {
        $studentAssessment->update([
            'completed_at' => now(),
            'status' => 'completed'
        ]);
        
        // Calculate scores
        $correctCount = 0;
        foreach ($answers as $questionId => $answer) {
            $question = Question::find($questionId);
            $isCorrect = ($answer === $question->correct_answer);
            
            if ($isCorrect) {
                $correctCount++;
            }
            
            StudentAnswer::create([
                'student_assessment_id' => $studentAssessment->id,
                'question_id' => $questionId,
                'selected_answer' => $answer,
                'is_correct' => $isCorrect
            ]);
        }
        
        // Create result record
        StudentResult::create([
            'student_id' => Auth::id(),
            'assessment_id' => $studentAssessment->assessment_id,
            'student_assessment_id' => $studentAssessment->id,
            'score' => $correctCount,
            'total_questions' => count($answers),
            'time_taken' => $studentAssessment->started_at->diffInMinutes(now()),
            'submitted_at' => now()
        ]);
    });
}
```

---

## FIX #9: Add Email Masking for Logs

### File: `app/Http/Controllers/Controller.php`

**Add these helper methods:**
```php
/**
 * Mask email for logging (user@example.com -> u***@example.com)
 */
protected function maskEmail(string $email): string
{
    $parts = explode('@', $email);
    if (count($parts) !== 2) {
        return '***@***.***';
    }
    
    $username = $parts[0];
    $domain = $parts[1];
    
    if (strlen($username) <= 2) {
        $maskedUsername = str_repeat('*', strlen($username));
    } else {
        $maskedUsername = substr($username, 0, 1) . str_repeat('*', strlen($username) - 2) . substr($username, -1);
    }
    
    return $maskedUsername . '@' . $domain;
}

/**
 * Mask IP address (192.168.1.100 -> 192.168.***.***) 
 */
protected function maskIP(string $ip): string
{
    $parts = explode('.', $ip);
    if (count($parts) === 4) {
        return $parts[0] . '.' . $parts[1] . '.***.***';
    }
    
    // IPv6 or invalid
    return '***.***.***';
}
```

### Then update logging:

**File: `app/Http/Controllers/SupabaseAuthController.php`**

**Find (Line 175-178):**
```php
\Log::info('Login attempt started', [
    'email' => $request->input('email'),
    'ip' => $request->ip(),
]);
```

**Replace with:**
```php
\Log::info('Login attempt started', [
    'email' => $this->maskEmail($request->input('email')),
    'ip' => $this->maskIP($request->ip()),
]);
```

---

## FIX #10: Add Cache Invalidation

### File: `app/Http/Controllers/AdminController.php`

**Find the approve method and add cache clearing:**

**After approving student:**
```php
public function approve($id)
{
    // ... approval logic ...
    
    // CLEAR RELEVANT CACHES
    Cache::forget('admin_dashboard_stats');
    Cache::forget('admin_dashboard_avg_score');
    Cache::forget('admin_recent_assessments');
    Cache::forget('admin_top_students');
    
    // Or use tags if implemented
    // Cache::tags(['admin_stats', 'student_list'])->flush();
    
    return redirect()->route('admin.pending-students')
        ->with('status', 'Student approved successfully');
}
```

**Repeat for:**
- Student rejection
- Assessment creation/deletion
- Result submission

---

## 🚀 DEPLOYMENT FIXES

### Fix Production Timeout Issues

### File: `config/database.php`

**Find the pgsql connection:**
```php
'pgsql' => [
    'driver' => 'pgsql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    // ... existing config ...
],
```

**Add these options:**
```php
'pgsql' => [
    'driver' => 'pgsql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'forge'),
    'username' => env('DB_USERNAME', 'forge'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'prefix' => '',
    'prefix_indexes' => true,
    'search_path' => 'public',
    'sslmode' => env('DB_SSLMODE', 'prefer'),
    
    // ADD THESE FOR BETTER CONNECTION HANDLING
    'connect_timeout' => 10, // Fail fast instead of hanging
    'options' => [
        \PDO::ATTR_PERSISTENT => true, // Connection pooling
        \PDO::ATTR_EMULATE_PREPARES => true,
        \PDO::ATTR_TIMEOUT => 10,
    ],
],
```

---

## 📋 VERIFICATION CHECKLIST

After applying fixes, verify:

- [ ] All hardcoded credentials removed
- [ ] Rate limiting working (test by making rapid requests)
- [ ] Search input sanitized (test with `<script>` tags)
- [ ] SQL queries using parameterized values
- [ ] Session regenerates before login
- [ ] Email masking in logs
- [ ] Database transactions wrapping critical operations
- [ ] Cache invalidation on data changes
- [ ] Chatbot rate limited and input reduced
- [ ] Production deployment stable

---

## 🧪 TESTING COMMANDS

### Test Rate Limiting:
```bash
# Try to login 6 times rapidly - should get rate limited
for i in {1..6}; do curl -X POST http://localhost:8000/login -d "email=test@test.com&password=test"; done
```

### Test Database Connection:
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

### Clear All Caches:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 🔄 GIT COMMIT STRATEGY

### Commit 1: Critical Security Fixes
```bash
git add routes/web.php
git commit -m "fix: remove hardcoded database credentials and add rate limiting to auth routes"
```

### Commit 2: Input Sanitization
```bash
git add app/Http/Controllers/Controller.php app/Http/Controllers/*/
git commit -m "fix: add search input sanitization to prevent XSS"
```

### Commit 3: SQL Injection Prevention
```bash
git add app/Http/Controllers/AdminReportController.php
git commit -m "fix: use parameterized queries in whereRaw to prevent SQL injection"
```

### Commit 4: Session Security
```bash
git add app/Http/Controllers/AuthController.php
git commit -m "fix: regenerate session before login to prevent session fixation"
```

### Commit 5: Database Optimizations
```bash
git add app/Http/Controllers/Student/AssessmentController.php config/database.php
git commit -m "feat: add database transactions and connection pooling"
```

---

## ⚡ QUICK FIX SCRIPT

Create a file `apply-critical-fixes.sh`:

```bash
#!/bin/bash

echo "🔧 Applying Critical Fixes..."

# Backup current files
cp routes/web.php routes/web.php.backup
cp app/Http/Controllers/AuthController.php app/Http/Controllers/AuthController.php.backup

echo "✅ Backups created"

# TODO: Apply fixes (manual review recommended)

echo "📝 Please manually apply fixes from CRITICAL_FIXES.md"
echo "🔍 Review each change before applying"
echo "✅ Test thoroughly after each fix"

```

---

**IMPORTANT:** Test each fix individually before proceeding to the next one!

