# Product Requirements Document
# College Placement Training Portal

## 1. Product Overview

The College Placement Training Portal is a comprehensive web-based platform designed to streamline and enhance college placement training programs. It combines automated assessment management, real-time analytics, and AI-powered student assistance to create an efficient learning ecosystem.

### 1.1 Vision
To revolutionize placement training in educational institutions by providing an intelligent, automated platform that reduces administrative burden while maximizing student learning outcomes.

### 1.2 Target Users
- **Administrators**: College faculty, placement coordinators, training managers
- **Students**: College students preparing for placement interviews and assessments

## 2. Core Features

### 2.1 Authentication & User Management

#### 2.1.1 Registration
- **FR-AUTH-001**: System shall allow users to register with name, email, password, and role (student/admin)
- **FR-AUTH-002**: System shall validate email format and password strength during registration
- **FR-AUTH-003**: System shall prevent duplicate email registrations
- **FR-AUTH-004**: System shall require student accounts to be approved by admin before access

#### 2.1.2 Login & Session Management
- **FR-AUTH-005**: System shall authenticate users with email and password
- **FR-AUTH-006**: System shall maintain user sessions securely
- **FR-AUTH-007**: System shall provide "Remember Me" functionality
- **FR-AUTH-008**: System shall redirect users to role-appropriate dashboards after login
- **FR-AUTH-009**: System shall implement rate limiting to prevent brute force attacks

#### 2.1.3 Password Management
- **FR-AUTH-010**: System shall allow users to reset forgotten passwords via email
- **FR-AUTH-011**: System shall enforce password complexity requirements
- **FR-AUTH-012**: System shall hash all passwords using bcrypt

### 2.2 Admin Features

#### 2.2.1 Admin Dashboard
- **FR-ADMIN-001**: System shall display total number of students, assessments, and completion rates
- **FR-ADMIN-002**: System shall show recent student registrations and activity feed
- **FR-ADMIN-003**: System shall provide quick action buttons for common tasks
- **FR-ADMIN-004**: System shall display visual charts for key metrics
- **FR-ADMIN-005**: System shall refresh dashboard statistics in real-time

#### 2.2.2 Student Management
- **FR-ADMIN-006**: System shall display list of pending student registrations
- **FR-ADMIN-007**: System shall allow admin to approve student accounts individually
- **FR-ADMIN-008**: System shall allow admin to reject student accounts with reason
- **FR-ADMIN-009**: System shall support bulk approve/reject operations
- **FR-ADMIN-010**: System shall send email notifications to students on approval/rejection
- **FR-ADMIN-011**: System shall allow admin to view approved and rejected student lists
- **FR-ADMIN-012**: System shall allow admin to restore rejected students
- **FR-ADMIN-013**: System shall allow admin to revoke access from approved students

#### 2.2.3 Assessment Management
- **FR-ADMIN-014**: System shall allow admin to create new assessments with title, description, duration
- **FR-ADMIN-015**: System shall allow admin to set passing marks for assessments
- **FR-ADMIN-016**: System shall allow admin to assign categories to assessments
- **FR-ADMIN-017**: System shall allow admin to configure if multiple attempts are allowed
- **FR-ADMIN-018**: System shall allow admin to activate/deactivate assessments
- **FR-ADMIN-019**: System shall allow admin to edit existing assessments
- **FR-ADMIN-020**: System shall allow admin to delete assessments (if no attempts exist)
- **FR-ADMIN-021**: System shall display list of all assessments with statistics

#### 2.2.4 Question Bank Management
- **FR-ADMIN-022**: System shall allow admin to add questions to assessments
- **FR-ADMIN-023**: System shall support multiple choice questions with 4 options (A, B, C, D)
- **FR-ADMIN-024**: System shall allow admin to specify correct answer for each question
- **FR-ADMIN-025**: System shall allow admin to assign categories to questions
- **FR-ADMIN-026**: System shall allow admin to set time per question
- **FR-ADMIN-027**: System shall allow admin to edit existing questions
- **FR-ADMIN-028**: System shall allow admin to delete questions
- **FR-ADMIN-029**: System shall display all questions for an assessment
- **FR-ADMIN-030**: System shall support ordering of questions in assessments

#### 2.2.5 Reports & Analytics
- **FR-ADMIN-031**: System shall generate assessment-wise performance reports
- **FR-ADMIN-032**: System shall generate student-wise performance reports
- **FR-ADMIN-033**: System shall provide category-wise analysis of results
- **FR-ADMIN-034**: System shall analyze question difficulty based on success rates
- **FR-ADMIN-035**: System shall display average scores, completion rates, pass rates
- **FR-ADMIN-036**: System shall allow exporting reports to CSV format
- **FR-ADMIN-037**: System shall show visual charts for performance trends

#### 2.2.6 RAG Knowledge Sync
- **FR-ADMIN-038**: System shall provide interface to sync knowledge base with RAG service
- **FR-ADMIN-039**: System shall display RAG service health status
- **FR-ADMIN-040**: System shall show last sync timestamp

### 2.3 Student Features

#### 2.3.1 Student Dashboard
- **FR-STUDENT-001**: System shall display student's personal statistics (tests taken, average score, completion rate)
- **FR-STUDENT-002**: System shall show list of available assessments
- **FR-STUDENT-003**: System shall display upcoming and recent assessments
- **FR-STUDENT-004**: System shall show performance trends over time
- **FR-STUDENT-005**: System shall provide quick access to assessment history

#### 2.3.2 Assessment Taking
- **FR-STUDENT-006**: System shall display assessment details before starting (duration, questions, passing marks)
- **FR-STUDENT-007**: System shall show countdown timer during assessment
- **FR-STUDENT-008**: System shall allow navigation between questions
- **FR-STUDENT-009**: System shall save answers automatically
- **FR-STUDENT-010**: System shall allow students to flag questions for review
- **FR-STUDENT-011**: System shall show progress indicator (questions answered/total)
- **FR-STUDENT-012**: System shall auto-submit assessment when time expires
- **FR-STUDENT-013**: System shall allow manual submission before time expires
- **FR-STUDENT-014**: System shall warn before submission with review summary
- **FR-STUDENT-015**: System shall prevent back navigation after time expires

#### 2.3.3 Results & Performance
- **FR-STUDENT-016**: System shall calculate and display results immediately after submission
- **FR-STUDENT-017**: System shall show score, percentage, pass/fail status
- **FR-STUDENT-018**: System shall display correct answers for all questions
- **FR-STUDENT-019**: System shall highlight student's answers (correct in green, incorrect in red)
- **FR-STUDENT-020**: System shall show category-wise performance breakdown
- **FR-STUDENT-021**: System shall display time taken for assessment
- **FR-STUDENT-022**: System shall compare student's score with average score
- **FR-STUDENT-023**: System shall maintain complete assessment history
- **FR-STUDENT-024**: System shall allow viewing previous attempt results
- **FR-STUDENT-025**: System shall show performance analytics and trends

#### 2.3.4 AI Chatbot
- **FR-STUDENT-026**: System shall provide AI chatbot interface on student dashboard
- **FR-STUDENT-027**: System shall accept natural language questions from students
- **FR-STUDENT-028**: System shall provide context-aware responses based on student data
- **FR-STUDENT-029**: System shall answer questions about assessments, performance, and guidance
- **FR-STUDENT-030**: System shall maintain conversation history
- **FR-STUDENT-031**: System shall provide fallback responses when RAG service is unavailable
- **FR-STUDENT-032**: System shall display chatbot response time
- **FR-STUDENT-033**: System shall allow clearing conversation history

#### 2.3.5 Profile Management
- **FR-STUDENT-034**: System shall allow students to view and edit profile information
- **FR-STUDENT-035**: System shall allow students to change password
- **FR-STUDENT-036**: System shall allow students to request account deletion
- **FR-STUDENT-037**: System shall send confirmation email for account deletion
- **FR-STUDENT-038**: System shall provide 48-hour cancellation window for account deletion

### 2.4 Common Features

#### 2.4.1 Email Notifications
- **FR-EMAIL-001**: System shall send verification email on registration (if enabled)
- **FR-EMAIL-002**: System shall send approval notification to students
- **FR-EMAIL-003**: System shall send rejection notification with reason
- **FR-EMAIL-004**: System shall send password reset links
- **FR-EMAIL-005**: System shall send account deletion confirmation emails

#### 2.4.2 Security
- **FR-SEC-001**: System shall implement CSRF protection on all forms
- **FR-SEC-002**: System shall sanitize all user inputs to prevent XSS attacks
- **FR-SEC-003**: System shall use prepared statements to prevent SQL injection
- **FR-SEC-004**: System shall enforce HTTPS in production environment
- **FR-SEC-005**: System shall implement role-based access control using middleware
- **FR-SEC-006**: System shall log out inactive users after timeout period
- **FR-SEC-007**: System shall validate all server-side inputs

## 3. Non-Functional Requirements

### 3.1 Performance
- **NFR-PERF-001**: System shall load dashboard within 2 seconds
- **NFR-PERF-002**: System shall handle 100 concurrent users without degradation
- **NFR-PERF-003**: System shall calculate assessment results within 3 seconds
- **NFR-PERF-004**: Chatbot responses shall be delivered within 5 seconds
- **NFR-PERF-005**: System shall use database indexes for query optimization

### 3.2 Scalability
- **NFR-SCALE-001**: System shall support up to 10,000 registered users
- **NFR-SCALE-002**: System shall support up to 1,000 assessments
- **NFR-SCALE-003**: System shall handle 50 simultaneous assessment attempts

### 3.3 Reliability
- **NFR-REL-001**: System shall have 99% uptime
- **NFR-REL-002**: System shall implement health check endpoints
- **NFR-REL-003**: System shall gracefully handle RAG service failures
- **NFR-REL-004**: System shall auto-save student answers every 30 seconds

### 3.4 Usability
- **NFR-USE-001**: System shall be responsive and mobile-friendly
- **NFR-USE-002**: System shall provide intuitive navigation
- **NFR-USE-003**: System shall display clear error messages
- **NFR-USE-004**: System shall show loading indicators for async operations
- **NFR-USE-005**: System shall support keyboard navigation

### 3.5 Compatibility
- **NFR-COMP-001**: System shall support Chrome, Firefox, Safari, Edge browsers
- **NFR-COMP-002**: System shall work on desktop, tablet, and mobile devices
- **NFR-COMP-003**: System shall support screen readers for accessibility

### 3.6 Maintainability
- **NFR-MAINT-001**: System shall follow MVC architecture pattern
- **NFR-MAINT-002**: System shall have clear separation of concerns
- **NFR-MAINT-003**: System shall include comprehensive logging
- **NFR-MAINT-004**: System shall have database migrations for version control

## 4. Technical Requirements

### 4.1 Technology Stack
- **Backend**: Laravel 12.x with PHP 8.2+
- **Frontend**: Bootstrap 5, Tailwind CSS 4.0, Alpine.js
- **Database**: PostgreSQL on Supabase
- **AI Service**: Python FastAPI RAG service with OpenRouter
- **Build Tools**: Vite 7.0, NPM

### 4.2 Infrastructure
- **Hosting**: Render.com, Docker, or Oracle Cloud
- **Database**: Supabase PostgreSQL with SSL
- **Email**: SMTP server configuration
- **Port**: 8000 for web app, 8001 for RAG service

### 4.3 Integrations
- Supabase PostgreSQL database
- OpenRouter API for AI responses
- SMTP email service
- Python RAG microservice

## 5. User Flows

### 5.1 Student Registration & Approval Flow
1. Student visits registration page
2. Student enters name, email, password, role
3. System validates input and creates account (pending status)
4. Admin views pending students list
5. Admin reviews student details
6. Admin approves or rejects with reason
7. System sends email notification to student
8. Student can login if approved

### 5.2 Assessment Taking Flow
1. Student logs in and views dashboard
2. Student selects assessment from available list
3. System displays assessment details
4. Student clicks "Start Assessment"
5. System starts timer and displays first question
6. Student answers questions with navigation
7. System auto-saves answers periodically
8. Student submits or time expires
9. System calculates score immediately
10. Student views detailed results

### 5.3 Chatbot Interaction Flow
1. Student opens chatbot interface
2. Student types question
3. Laravel sends request to RAG service
4. RAG service retrieves context from database
5. OpenRouter generates AI response
6. System displays response to student
7. Conversation history is saved

## 6. API Specifications

### 6.1 Authentication Endpoints
- `POST /register` - User registration
- `POST /login` - User authentication
- `POST /logout` - User logout
- `POST /password/email` - Request password reset
- `POST /password/reset` - Reset password

### 6.2 Admin Endpoints
- `GET /admin/dashboard` - Admin dashboard data
- `GET /admin/students/pending` - Pending approvals
- `POST /admin/students/{id}/approve` - Approve student
- `POST /admin/students/{id}/reject` - Reject student
- `GET /admin/assessments` - List assessments
- `POST /admin/assessments` - Create assessment
- `GET /admin/reports` - Generate reports

### 6.3 Student Endpoints
- `GET /student/dashboard` - Student dashboard data
- `GET /student/assessments` - Available assessments
- `POST /student/test/{id}/submit` - Submit assessment
- `GET /student/results/{id}` - View results
- `POST /student/rag-chat` - Chat with AI
- `GET /student/history` - Assessment history

## 7. Data Models

### 7.1 User
- id, name, email, password, role, email_verified_at, is_approved, rejection_reason, register_number

### 7.2 Assessment
- id, title, description, duration, passing_marks, category, is_active, allow_multiple_attempts

### 7.3 Question
- id, assessment_id, category, question_text, option_a, option_b, option_c, option_d, correct_answer, time_per_question

### 7.4 StudentAssessment
- id, user_id, assessment_id, started_at, completed_at, score, status

### 7.5 StudentAnswer
- id, student_assessment_id, question_id, selected_answer, is_correct

## 8. Success Metrics

- Student approval time reduced by 70%
- Assessment grading automated (100% accuracy)
- Chatbot response accuracy >85%
- User satisfaction score >4/5
- System uptime >99%
- Page load time <2 seconds
- 100% of assessments completed without technical issues

## 9. Future Enhancements

- Mobile applications (iOS/Android)
- Video interview preparation
- Resume builder
- Job matching algorithm
- Company integration portal
- Adaptive learning paths
- Predictive analytics for student success
- Gamification elements
- Peer learning features
- Integration with LinkedIn and job boards

