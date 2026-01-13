@extends('student.layout')

@section('content')

<head>
    <title>Manual Course Registration</title>
</head>

<div class="registration-container">
    <div class="registration-header">
        <h1>Manual Course Registration</h1>
        <p class="subtitle">Request manual registration for courses that require special approval</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            Please correct the errors below:
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="registration-card">
        <form method="POST" action="{{ route('student.manual-register.store') }}" class="registration-form">
            @csrf
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <input type="hidden" name="registration_type" value="MANUAL">
            
            <!-- Subject Information -->
            <div class="form-section">
                <h3>Course Information</h3>
                <div class="form-grid">
                    <!--subject name-->
                    <div class="form-group">
                        <label for="subject_name">
                            Subject Name :
                        </label>
                        <input type="text" 
                               id="subject_name"
                               name="subject_name" 
                               value="{{ old('subject_name') }}"
                               placeholder="e.g., Introduction to Computer Science"
                               required>
                    </div>

                    <!--course code-->
                    <div class="form-group">
                        <label for="course_code">
                            Course Code :
                        </label>
                        <input type="text" 
                               id="course_code" 
                               name="course_code" 
                               value="{{ old('course_code') }}"
                               placeholder="e.g., BICS 2303"
                               required>
                    </div>
                    
                    <!--current credit hour-->
                    <div class="form-group">
                        <label for="current_credit_hours">
                            Current Credit Hours :
                        </label>
                        <input type="number" 
                               step="0.5" 
                               min="0"
                               max="999.99"
                               id="current_credit_hours" 
                               name="current_credit_hours" 
                               value="{{ old('current_credit_hours') }}"
                               placeholder="e.g., 12.5"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="completed_credit_hours">
                            Completed Credit Hours :
                        </label>
                        <input type="number" 
                               step="0.5" 
                               min="0"
                               max="999.99"
                               id="completed_credit_hours" 
                               name="completed_credit_hours" 
                               value="{{ old('completed_credit_hours') }}"
                               placeholder="e.g., 3"
                               >
                    </div>

                    <div class="form-group">
                        <label for="cgpa">
                            CGPA :
                        </label>
                        <input type="number" 
                               step="any" 
                               id="cgpa" 
                               name="cgpa" 
                               value="{{ old('cgpa') }}"
                               placeholder="e.g., 3.5"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="requested_section">
                            Requested Section :
                        </label>
                        <input type="text" 
                               id="requested_section" 
                               name="requested_section" 
                               value="{{ old('requested_section') }}"
                               placeholder="e.g., Section 5"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="semester">
                            Semester :
                        </label>
                        <select id="semester" name="semester" required>
                            <option value="">Select Semester</option>
                            <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>Semester 1</option>
                            <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Semester 2</option>
                            <option value="3" {{ old('semester') == '3' ? 'selected' : '' }}>Semester 3</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Reason Section -->
            <div class="form-section">
                <h3>Registration Details</h3>
                <div class="form-group">
                    <label for="reason">
                        Reason for Manual Registration :
                    </label>
                    <textarea id="reason" 
                              name="reason" 
                              rows="2" 
                              placeholder="Please provide a detailed explanation for your manual registration request."
                              required>{{ old('reason') }}</textarea>
                </div>
            </div>


            <!--Submit -->

                <div class="form-actions">
                    <button type="button" class="btn-clear" onclick="clearForm()">
                        Clear Form
                    </button>
                    <button type="submit" class="btn-submit">
                        Submit Registration Request
                    </button>
                </div>
                
                <div class="form-footer">
                    Your request will be reviewed within 3-5 working days.</p>
                </div>
        </form>
    </div>
</div>

<style>
    .registration-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .registration-header {
        text-align: center;
        margin-bottom: 40px;
        padding-bottom: 20px;
        border-bottom: 2px solid #1abc9c;
    }
    
    .registration-header h1 {
        color: #2c3e50;
        font-size: 32px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
    }
    
    .subtitle {
        color: #7f8c8d;
        font-size: 16px;
        margin-top: 5px;
    }
    
    .alert {
        padding: 15px 20px;
        margin-bottom: 25px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    .alert ul {
        margin: 10px 0 0 20px;
        padding: 0;
    }
    
    .registration-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .registration-form {
        padding: 30px;
    }
    
    .form-section {
        margin-bottom: 35px;
        padding-bottom: 25px;
        border-bottom: 1px solid #ecf0f1;
    }
    
    .form-section h3 {
        color: #2c3e50;
        font-size: 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }
    
    .form-group {
        margin-bottom: 20px;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #34495e;
        font-weight: 600;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 15px;
        font-family: inherit;
        transition: all 0.3s;
        background-color: #f8f9fa;
    }
    
    .form-hint {
        display: block;
        margin-top: 6px;
        color: #7f8c8d;
        font-size: 13px;
        font-style: italic;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 30px;
    }
    
    .btn-clear, .btn-submit {
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    
    .btn-clear {
        background-color: #f8f9fa;
        color: #7f8c8d;
        border: 1px solid #ddd;
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
        color: white;
        min-width: 250px;
    }
    
    .btn-submit:hover {
        background: linear-gradient(135deg, #16a085 0%, #149174 100%);
        box-shadow: 0 5px 15px rgba(26, 188, 156, 0.3);
    }
    
    .form-footer {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #ecf0f1;
        text-align: center;
        color: #7f8c8d;
        font-size: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }
    
    @media (max-width: 768px) {
        .registration-form {
            padding: 20px;
        }
        
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn-clear, .btn-submit {
            width: 100%;
        }
    }
</style>

<script>
    // Clear form function
    function clearForm() {
        if(confirm('Are you sure you want to clear all form data?')) {
            document.querySelector('.registration-form').reset();
            document.getElementById('charCount').textContent = 0;
        }
    }
</script>

@endsection