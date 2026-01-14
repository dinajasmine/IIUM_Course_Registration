@extends('student.layout')

@section('content')

<head>
    <title>Course Registration</title>
</head>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
        display: flex;
        min-height: 100vh;
        background-color: #f5f7fa;
    }
    
    /* Main content area */
    .main-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    
    .registration-container {
        flex-grow: 1;
        padding: 30px 40px;
    }
    
    .registration-header {
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 2px solid #ecf0f1;
    }
    
    .registration-header h1 {
        font-size: 2rem;
        color: #2c3e50;
        display: flex;
        align-items: center;
    }
    
    .registration-header h1 i {
        margin-right: 15px;
        color: #3498db;
    }
    
    .alert {
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 25px;
        font-weight: 500;
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
    
    .alert-error ul {
        margin-top: 10px;
        margin-left: 20px;
    }
    
    /* Course cards section */
    .courses-section {
        margin-top: 20px;
    }
    
    .section-title {
        font-size: 1.5rem;
        color: #2c3e50;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 2px solid #ecf0f1;
        display: flex;
        align-items: center;
    }
    
    .section-title i {
        margin-right: 10px;
        color: #3498db;
    }
    
    .course-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
    }
    
    .course-card {
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }
    
    .course-header {
        padding: 20px;
        border-bottom: 1px solid #ecf0f1;
        display: flex;
        align-items: center;
    }
    
    .course-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        font-size: 1.5rem;
        color: white;
    }
    
    .course-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #2c3e50;
    }
    
    .course-code {
        color: #7f8c8d;
        font-size: 0.95rem;
        margin-top: 3px;
    }
    
    .course-content {
        padding: 20px;
    }
    
    .course-description {
        color: #5a6c7d;
        line-height: 1.5;
        margin-bottom: 20px;
        font-size: 0.95rem;
    }
    
    .course-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        font-size: 0.9rem;
    }
    
    .course-details span {
        color: #5a6c7d;
    }
    
    .course-details .value {
        color: #2c3e50;
        font-weight: 600;
    }
    
    .course-actions {
        display: flex;
        gap: 10px;
    }
    
    .btn-add, .btn-details {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .btn-add {
        background-color: #2ecc71;
        color: white;
    }
    
    .btn-add:hover {
        background-color: #27ae60;
    }
    
    .btn-details {
        background-color: #f8f9fa;
        color: #3498db;
        border: 1px solid #e0e6ed;
    }
    
    .btn-details:hover {
        background-color: #eef5ff;
    }
    
    .btn-add i, .btn-details i {
        margin-right: 8px;
    }
    
    
    /* Responsive adjustments */
    @media (max-width: 1100px) {
        .course-cards {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }
    
    @media (max-width: 768px) {
        body {
            flex-direction: column;
        }
        
        .banner, .registration-container {
            padding: 20px;
        }
        
        .course-cards {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="main-content">

    
    <!-- Registration Content -->
    <div class="registration-container">
        <div class="registration-header">
            <h1><i class="fas fa-clipboard-list"></i> Course Registration</h1>
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
            
        <!-- Course Registration Section -->
        <div class="courses-section">
            <h3 class="section-title"><i class="fas fa-book-open"></i> Available Courses</h3>
            
            <div class="course-cards">
                <!-- Course 1 -->
                <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Introduction to Human Computer Interaction</div>
                            <div class="course-code">BICS 2303</div>
                            <div>SECTION: <span class="value">1</span></div>
                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Dr. Amir 'Aatief</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">24/30</span></div>
                                <div>Schedule: <span class="value">T-TH 10:00-11:20</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>
                
                <!-- Course 2 -->
                <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Introduction to Human Computer Interaction</div>
                            <div class="course-code">BICS 2303</div>
                            <div>SECTION: <span class="value">2</span></div>
                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Dr. Elin Eliana</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">18/25</span></div>
                                <div>Schedule: <span class="value">M-W 11:00-12:15</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>
                
                <!-- Course 3 -->
                <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Introduction to Human Computer Interaction</div>
                            <div class="course-code">BICS 2303</div>
                            <div>SECTION: <span class="value">3</span></div>
                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Dr. Afiq Ammar</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">30/35</span></div>
                                <div>Schedule: <span class="value">M-W 14:00-15:20</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>
                
                <!-- Course 4 -->
                <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Introduction to Human Computer Interaction</div>
                            <div class="course-code">BICS 2303</div>
                            <div>SECTION: <span class="value">4</span></div>
                            
                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Prof. Sarah Johnson</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">22/28</span></div>
                                <div>Schedule: <span class="value">T-TH 8:30-9:50</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>
                
                <!-- Course 5 -->
                <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Introduction to Database Management</div>
                            <div class="course-code">BICS 1302</div>
                            <div>SECTION: <span class="value">1</span></div>

                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Prof. Lisa Chen</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">15/20</span></div>
                                <div>Schedule: <span class="value">M-W 10:00-11:20</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>
                
                <!-- Course 6 -->
                <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Introduction to Database Management</div>
                            <div class="course-code">BICS 1302</div>
                            <div>SECTION: <span class="value">2</span></div>

                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Prof. Abubakar</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">15/20</span></div>
                                <div>Schedule: <span class="value">M-W 11:20-12:50</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Introduction to Database Management</div>
                            <div class="course-code">BICS 1302</div>
                            <div>SECTION: <span class="value">3</span></div>

                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Prof. Ahmad</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">15/20</span></div>
                                <div>Schedule: <span class="value">T-TH 10:00-11:20</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Introduction to Database Management</div>
                            <div class="course-code">BICS 1302</div>
                            <div>SECTION: <span class="value">4</span></div>

                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Prof. Mimi Sarah</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">15/20</span></div>
                                <div>Schedule: <span class="value">M-W 8:00-9:20</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Web Technologies and Development</div>
                            <div class="course-code">BICS 1303</div>
                            <div>SECTION: <span class="value">1</span></div>

                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Prof. Maisarah</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">15/20</span></div>
                                <div>Schedule: <span class="value">M-W 8:00-9:20</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>

                 <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Web Technologies and Development</div>
                            <div class="course-code">BICS 1303</div>
                            <div>SECTION: <span class="value">2</span></div>

                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Prof. Muhamad</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">15/20</span></div>
                                <div>Schedule: <span class="value">T-TH 8:00-9:20</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>

                 <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Web Technologies and Development</div>
                            <div class="course-code">BICS 1303</div>
                            <div>SECTION: <span class="value">3</span></div>

                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Prof. Dina</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">15/20</span></div>
                                <div>Schedule: <span class="value">M-W 10:00-11:20</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>

                 <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Web Technologies and Development</div>
                            <div class="course-code">BICS 1303</div>
                            <div>SECTION: <span class="value">1</span></div>

                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Prof. Maisarah</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">15/20</span></div>
                                <div>Schedule: <span class="value">M-W 8:00-9:20</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>

                 <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Fundamentals of Information Technology</div>
                            <div class="course-code">BIIT 1304</div>
                            <div>SECTION: <span class="value">1</span></div>

                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Prof. Azlin</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">15/20</span></div>
                                <div>Schedule: <span class="value">M-W 8:00-9:20</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Fundamentals of Information Technology</div>
                            <div class="course-code">BIIT 1304</div>
                            <div>SECTION: <span class="value">2</span></div>

                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Prof. Normi Sham</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">15/20</span></div>
                                <div>Schedule: <span class="value">M-W 10:00-11:20</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Fundamentals of Information Technology</div>
                            <div class="course-code">BIIT 1304</div>
                            <div>SECTION: <span class="value">3</span></div>

                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Prof. Badri</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">15/20</span></div>
                                <div>Schedule: <span class="value">T-TH 8:00-9:20</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>

                <div class="course-card">
                    <div class="course-header">
                        <div>
                            <div class="course-title">Fundamentals of Information Technology</div>
                            <div class="course-code">BIIT 1304</div>
                            <div>SECTION: <span class="value">4</span></div>

                        </div>
                    </div>
                    
                    <div class="course-content">
                        
                        
                        <div class="course-details">
                            <div>
                                <div>Instructor: <span class="value">Prof. Sharyar</span></div>
                                <div>Credits: <span class="value">3</span></div>
                            </div>
                            <div>
                                <div>Seats: <span class="value">15/20</span></div>
                                <div>Schedule: <span class="value">M-W 8:00-9:20</span></div>
                            </div>
                        </div>
                        
                        <div class="course-actions">
                            <button class="btn-add"><i class="fas fa-plus-circle"></i> Add Course</button>
                            <button class="btn-details"><i class="fas fa-info-circle"></i> Details</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Add interactivity to the "Add Course" buttons
    document.addEventListener('DOMContentLoaded', function() {
        const addButtons = document.querySelectorAll('.btn-add');
        
        addButtons.forEach(button => {
            button.addEventListener('click', function() {
                const courseCard = this.closest('.course-card');
                const courseTitle = courseCard.querySelector('.course-title').textContent;
                const courseCode = courseCard.querySelector('.course-code').textContent;
                
                // Change button state
                this.innerHTML = '<i class="fas fa-check"></i> Added';
                this.style.backgroundColor = '#3498db';
                this.disabled = true;
                
                // Show confirmation message
                alert(`Successfully added ${courseCode} - ${courseTitle} to your schedule!`);
            });
        });
        
        // Details button functionality
        const detailButtons = document.querySelectorAll('.btn-details');
        
        detailButtons.forEach(button => {
            button.addEventListener('click', function() {
                const courseCard = this.closest('.course-card');
                const courseTitle = courseCard.querySelector('.course-title').textContent;
                const courseCode = courseCard.querySelector('.course-code').textContent;
                
                alert(`Viewing details for ${courseCode} - ${courseTitle}\n\nClick "Add Course" to register for this class.`);
            });
        });
    });
</script>

@endsection
