<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IIUM Course Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .subject-box {
            border: 2px solid #d1d5db;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .subject-box:hover {
            border-color: #3b82f6;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
        }
        .registered-box {
            background-color: #f8fafc;
            border-left: 4px solid #3b82f6;
        }
        .section-radio:checked + .section-label {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
        .popup-overlay {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">IIUM Course Registration</h1>
                    <p class="text-gray-600 text-sm">Semester 2 2023/2024</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="font-medium">{{ $student->name }}</p>
                        <p class="text-sm text-gray-600">{{ $student->matric_no }}</p>
                        <p class="text-xs text-gray-500">{{ $student->program }} | Semester {{ $student->semester }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Available Courses -->
            <div class="lg:col-span-2">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Available Courses</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($subjects as $subject)
                            @if($subject->sections->count() > 0)
                                <div class="subject-box bg-white p-4">
                                    <!-- Subject Header -->
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h3 class="font-bold text-lg text-gray-800">{{ $subject->code }}</h3>
                                            <p class="text-sm text-gray-600">{{ $subject->name }}</p>
                                        </div>
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                                            {{ $subject->credit_hours }} Credit{{ $subject->credit_hours > 1 ? 's' : '' }}
                                        </span>
                                    </div>

                                    <!-- Sections -->
                                    <div class="space-y-3">
                                        @foreach($subject->sections as $section)
                                            <div class="border rounded p-3 {{ $section->registered_count >= $section->capacity ? 'opacity-60' : '' }}">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <div class="flex items-center mb-1">
                                                            <span class="font-medium text-gray-800 mr-2">Section {{ $section->section_code }}</span>
                                                            @if($section->section_name)
                                                                <span class="text-sm text-gray-600">({{ $section->section_name }})</span>
                                                            @endif
                                                        </div>
                                                        <div class="text-sm text-gray-600 space-y-1">
                                                            <div class="flex items-center">
                                                                <i class="far fa-clock w-4 mr-2"></i>
                                                                <span>{{ $section->time_slot }}</span>
                                                            </div>
                                                            @if($section->days)
                                                                <div class="flex items-center">
                                                                    <i class="far fa-calendar w-4 mr-2"></i>
                                                                    <span>{{ $section->days }}</span>
                                                                </div>
                                                            @endif
                                                            @if($section->venue)
                                                                <div class="flex items-center">
                                                                    <i class="far fa-building w-4 mr-2"></i>
                                                                    <span>{{ $section->venue }}</span>
                                                                </div>
                                                            @endif
                                                            @if($section->lecturer)
                                                                <div class="flex items-center">
                                                                    <i class="far fa-user w-4 mr-2"></i>
                                                                    <span>{{ $section->lecturer }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="text-sm {{ $section->registered_count >= $section->capacity ? 'text-red-500' : 'text-green-500' }} font-medium">
                                                            {{ $section->registered_count }}/{{ $section->capacity }}
                                                        </div>
                                                        @if($section->registered_count >= $section->capacity)
                                                            <span class="text-xs text-red-500">Full</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                @if($section->registered_count < $section->capacity)
                                                    <button onclick="registerSubject('{{ $subject->id }}', '{{ $section->id }}', '{{ $subject->code }} Section {{ $section->section_code }}')"
                                                            class="w-full mt-3 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded transition duration-200 flex items-center justify-center">
                                                        <i class="fas fa-plus mr-2"></i>
                                                        Add to Registration
                                                    </button>
                                                @else
                                                    <div class="w-full mt-3 py-2 bg-gray-300 text-gray-600 font-medium rounded text-center cursor-not-allowed">
                                                        Section Full
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Registered Courses -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 sticky top-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-800">Registered Courses</h2>
                        <div class="flex items-center">
                            <i class="fas fa-book text-blue-600 mr-2"></i>
                            <span class="font-medium">{{ $registeredSubjects->count() }} Course{{ $registeredSubjects->count() !== 1 ? 's' : '' }}</span>
                        </div>
                    </div>

                    <!-- Credits Summary -->
                    <div class="bg-blue-50 p-4 rounded-lg mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-700">Current Credits:</span>
                            @php
                                $totalCredits = 0;
                                foreach($registeredSubjects as $reg) {
                                    $totalCredits += $reg->subject->credit_hours;
                                }
                            @endphp
                            <span class="font-bold text-lg">{{ $totalCredits }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">Maximum Allowed:</span>
                            <span class="font-medium">{{ $student->max_credit ?? 18 }}</span>
                        </div>
                        <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" 
                                 style="width: {{ min(100, ($totalCredits / ($student->max_credit ?? 18)) * 100) }}%"></div>
                        </div>
                    </div>

                    <!-- Registered Courses List -->
                    <div id="registeredContainer" class="space-y-4 max-h-[400px] overflow-y-auto pr-2">
                        @if($registeredSubjects->isEmpty())
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-book-open text-4xl mb-4 opacity-50"></i>
                                <p>No courses registered yet</p>
                                <p class="text-sm mt-2">Click "Add" to register courses</p>
                            </div>
                        @else
                            @foreach($registeredSubjects as $registration)
                                <div class="registered-box p-4 rounded-lg shadow-sm">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="font-bold text-gray-800">{{ $registration->subject->code }}</h4>
                                            <p class="text-sm text-gray-600">{{ $registration->subject->name }}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button onclick="showEditPopup('{{ $registration->id }}', '{{ $registration->subject->code }}', '{{ $registration->subject->id }}')"
                                                    class="w-8 h-8 flex items-center justify-center text-blue-600 hover:bg-blue-50 rounded-full transition">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button onclick="dropSubject('{{ $registration->id }}', '{{ $registration->subject->code }}')"
                                                    class="w-8 h-8 flex items-center justify-center text-red-600 hover:bg-red-50 rounded-full transition">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Section:</span>
                                            <span class="font-medium">{{ $registration->section->section_code }} {{ $registration->section->section_name ? '(' . $registration->section->section_name . ')' : '' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Time:</span>
                                            <span>{{ $registration->section->time_slot }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Venue:</span>
                                            <span>{{ $registration->section->venue ?? 'TBA' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Credit:</span>
                                            <span class="font-medium">{{ $registration->subject->credit_hours }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 pt-6 border-t">
                        <button onclick="confirmAllRegistrations()"
                                class="w-full py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition duration-200 mb-3 flex items-center justify-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            Confirm Registration
                        </button>
                        <button onclick="clearAllRegistrations()"
                                class="w-full py-3 border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium rounded-lg transition duration-200">
                            Clear All
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Section Popup -->
    <div id="editPopup" class="hidden fixed inset-0 popup-overlay z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Change Section</h3>
                        <p id="currentCourseCode" class="text-gray-600"></p>
                    </div>
                    <button onclick="hideEditPopup()" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                
                <div class="mb-6">
                    <p class="text-gray-700 mb-4">Select a new section for this course:</p>
                    <div id="sectionsContainer" class="space-y-3">
                        <!-- Sections will be loaded here -->
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button onclick="hideEditPopup()"
                            class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-medium">
                        Cancel
                    </button>
                    <button onclick="updateSection()"
                            id="updateButton"
                            disabled
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                        Update Section
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Notification -->
    <div id="successNotification" class="hidden fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-3 text-xl"></i>
            <div>
                <p class="font-medium" id="notificationTitle"></p>
                <p class="text-sm opacity-90" id="notificationMessage"></p>
            </div>
        </div>
    </div>

    <script>
        let currentRegistrationId = null;
        let currentSubjectId = null;
        let selectedSectionId = null;

        // CSRF Token for AJAX requests
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        function showNotification(title, message, type = 'success') {
            const notification = document.getElementById('successNotification');
            const titleEl = document.getElementById('notificationTitle');
            const messageEl = document.getElementById('notificationMessage');
            
            titleEl.textContent = title;
            messageEl.textContent = message;
            
            // Change color based on type
            if (type === 'error') {
                notification.classList.remove('bg-green-500');
                notification.classList.add('bg-red-500');
            } else if (type === 'warning') {
                notification.classList.remove('bg-green-500');
                notification.classList.add('bg-yellow-500');
            } else {
                notification.classList.remove('bg-red-500', 'bg-yellow-500');
                notification.classList.add('bg-green-500');
            }
            
            notification.classList.remove('hidden');
            
            // Auto hide after 3 seconds
            setTimeout(() => {
                notification.classList.add('hidden');
            }, 3000);
        }

        function registerSubject(subjectId, sectionId, courseInfo) {
            if (!confirm(`Register for ${courseInfo}?`)) return;

            fetch('/student/registration/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    subject_id: subjectId,
                    section_id: sectionId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Success!', data.message);
                    // Reload page after 1 second
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error', 'An error occurred during registration', 'error');
            });
        }

        function showEditPopup(registrationId, courseCode, subjectId) {
            currentRegistrationId = registrationId;
            currentSubjectId = subjectId;
            
            // Set course code in popup
            document.getElementById('currentCourseCode').textContent = courseCode;
            
            // Load sections
            fetch(`/student/registration/sections/${subjectId}`)
                .then(response => response.json())
                .then(sections => {
                    const container = document.getElementById('sectionsContainer');
                    container.innerHTML = '';
                    
                    if (sections.length === 0) {
                        container.innerHTML = `
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-exclamation-circle text-3xl mb-3"></i>
                                <p>No other sections available</p>
                            </div>
                        `;
                        return;
                    }
                    
                    sections.forEach(section => {
                        const isFull = section.available_seats <= 0;
                        const sectionHtml = `
                            <div class="section-option ${isFull ? 'opacity-60' : 'cursor-pointer hover:bg-gray-50'}"
                                 onclick="${!isFull ? `selectSectionOption('${section.id}', '${section.section_code}', '${section.section_name}', '${section.time_slot}')` : ''}">
                                <input type="radio" 
                                       id="section_${section.id}" 
                                       name="section" 
                                       value="${section.id}"
                                       class="hidden section-radio"
                                       ${isFull ? 'disabled' : ''}>
                                <label for="section_${section.id}" 
                                       class="section-label block p-4 border rounded-lg ${isFull ? 'cursor-not-allowed' : 'cursor-pointer'}">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="font-medium flex items-center">
                                                <span>Section ${section.section_code}</span>
                                                ${section.section_name ? `<span class="ml-2 text-gray-600">(${section.section_name})</span>` : ''}
                                            </div>
                                            <div class="text-sm text-gray-600 mt-1">
                                                <div class="flex items-center">
                                                    <i class="far fa-clock w-4 mr-2"></i>
                                                    <span>${section.time_slot}</span>
                                                </div>
                                                ${section.venue ? `<div class="flex items-center mt-1">
                                                    <i class="far fa-building w-4 mr-2"></i>
                                                    <span>${section.venue}</span>
                                                </div>` : ''}
                                                ${section.lecturer ? `<div class="flex items-center mt-1">
                                                    <i class="far fa-user w-4 mr-2"></i>
                                                    <span>${section.lecturer}</span>
                                                </div>` : ''}
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm ${isFull ? 'text-red-500' : 'text-green-500'} font-medium">
                                                ${section.registered_count}/${section.capacity}
                                            </div>
                                            ${isFull ? '<span class="text-xs text-red-500">Full</span>' : 
                                                    `<span class="text-xs text-green-500">${section.available_seats} seats left</span>`}
                                        </div>
                                    </div>
                                </label>
                            </div>
                        `;
                        container.innerHTML += sectionHtml;
                    });
                    
                    // Show popup
                    document.getElementById('editPopup').classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Error', 'Failed to load sections', 'error');
                });
        }

        function selectSectionOption(sectionId, sectionCode, sectionName, timeSlot) {
            selectedSectionId = sectionId;
            
            // Remove selection from all options
            document.querySelectorAll('.section-option').forEach(option => {
                option.querySelector('.section-label').classList.remove('border-blue-500', 'bg-blue-50');
            });
            
            // Add selection to clicked option
            const selectedOption = document.querySelector(`input[value="${sectionId}"]`).parentElement;
            selectedOption.querySelector('.section-label').classList.add('border-blue-500', 'bg-blue-50');
            
            // Enable update button
            document.getElementById('updateButton').disabled = false;
        }

        function hideEditPopup() {
            document.getElementById('editPopup').classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentRegistrationId = null;
            currentSubjectId = null;
            selectedSectionId = null;
            document.getElementById('updateButton').disabled = true;
        }

        function updateSection() {
            if (!selectedSectionId) {
                showNotification('Warning', 'Please select a section first', 'warning');
                return;
            }

            const updateButton = document.getElementById('updateButton');
            updateButton.disabled = true;
            updateButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Updating...';

            fetch(`/student/registration/update-section/${currentRegistrationId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    new_section_id: selectedSectionId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Success!', data.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification('Error', data.message, 'error');
                    updateButton.disabled = false;
                    updateButton.innerHTML = 'Update Section';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error', 'Failed to update section', 'error');
                updateButton.disabled = false;
                updateButton.innerHTML = 'Update Section';
            });
        }

        function dropSubject(registrationId, courseCode) {
            if (!confirm(`Are you sure you want to drop ${courseCode}?`)) return;

            fetch(`/student/registration/drop/${registrationId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Dropped', data.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Error', 'Failed to drop subject', 'error');
            });
        }

        function confirmAllRegistrations() {
            const count = {{ $registeredSubjects->count() }};
            if (count === 0) {
                showNotification('Warning', 'No courses to confirm', 'warning');
                return;
            }

            if (confirm(`Confirm registration for ${count} course${count !== 1 ? 's' : ''}? This action is final.`)) {
                showNotification('Success!', 'Registration confirmed successfully');
                // You might want to redirect to a confirmation page
            }
        }

        function clearAllRegistrations() {
            const count = {{ $registeredSubjects->count() }};
            if (count === 0) {
                showNotification('Warning', 'No courses to clear', 'warning');
                return;
            }

            if (confirm(`Clear all ${count} registered course${count !== 1 ? 's' : ''}? This cannot be undone.`)) {
                // This would need server-side implementation
                showNotification('Info', 'This feature would clear all registrations', 'warning');
            }
        }

        // Close popup when clicking outside
        document.getElementById('editPopup').addEventListener('click', function(e) {
            if (e.target === this) {
                hideEditPopup();
            }
        });

        // Close popup with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideEditPopup();
            }
        });
    </script>
</body>
</html>