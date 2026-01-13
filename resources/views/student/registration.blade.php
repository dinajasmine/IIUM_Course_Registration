<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Course Registration - IIUM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-gradient-to-r from-teal-700 to-teal-500 text-white py-6">
        <div class="container mx-auto px-4 flex items-center justify-center">
            <div class="text-center">
                <div class="flex items-center justify-center gap-4 mb-2">
                    <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-2xl text-teal-800"></i>
                    </div>
                    <div class="text-left">
                        <h1 class="text-2xl font-bold">International Islamic University Malaysia</h1>
                        <p class="text-sm opacity-90">Garden of Knowledge and Virtue</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-48 bg-gradient-to-b from-slate-700 to-slate-800 text-white">
            <div class="py-4">
                <h2 class="px-6 text-lg font-semibold mb-4">Student Menu</h2>
                <nav>
                    <a href="#" class="block px-6 py-3 bg-slate-600 border-l-4 border-teal-400">Dashboard</a>
                    <a href="#" class="block px-6 py-3 hover:bg-slate-600 transition">Manual Registration</a>
                    <a href="#" class="block px-6 py-3 hover:bg-slate-600 transition">Schedule</a>
                    <a href="#" class="block px-6 py-3 hover:bg-slate-600 transition">Logout</a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-8">Course Registration</h1>

            <!-- Registered Courses -->
            @if($registeredCourses->isNotEmpty())
            <div class="mb-8 bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold text-lg mb-4">Registered: 
                    @foreach($registeredCourses as $reg)
                        {{ $reg->courseSection->course->code }} - {{ $reg->courseSection->course->name }}
                        @if(!$loop->last), @endif
                    @endforeach
                </h3>
                <button class="text-teal-600 hover:text-teal-700" onclick="openEditModal()">
                    <i class="fas fa-edit mr-1"></i> Edit
                </button>
            </div>
            @endif

            <!-- Course Cards Container -->
            <div class="relative">
                <div class="flex gap-6 overflow-x-auto pb-4" id="courseContainer">
                    @foreach($courses as $course)
                    <div class="min-w-[300px] bg-white rounded-lg shadow-md p-6 flex-shrink-0">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">{{ $course->code }}</h3>
                        
                        <div class="space-y-4">
                            @foreach($course->sections as $section)
                            @php
                                $isRegistered = $registeredCourses->contains(function($reg) use ($section) {
                                    return $reg->course_section_id == $section->id;
                                });
                                $isFull = $section->enrolled >= $section->capacity;
                            @endphp
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <span class="text-gray-600">Section</span>
                                    <span class="text-gray-600">Time Slot</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                @if($isRegistered)
                                    <button class="bg-teal-600 text-white px-6 py-2 rounded hover:bg-teal-700 transition flex items-center gap-2"
                                            onclick="unregisterCourse({{ $section->id }})">
                                        <i class="fas fa-check"></i> Add
                                    </button>
                                @elseif($isFull)
                                    <button class="bg-gray-300 text-gray-600 px-6 py-2 rounded cursor-not-allowed flex items-center gap-2"
                                            onclick="showFullMessage()">
                                        <i class="fas fa-sync-alt"></i> Full
                                    </button>
                                @else
                                    <button class="bg-teal-600 text-white px-6 py-2 rounded hover:bg-teal-700 transition"
                                            onclick="registerCourse({{ $section->id }})">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                @endif
                                
                                <span class="text-gray-600">({{ $section->section_number }})</span>
                                <span class="text-gray-600">{{ \Carbon\Carbon::parse($section->start_time)->format('g:i') }} - {{ \Carbon\Carbon::parse($section->end_time)->format('g:i') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Navigation Arrows -->
                <button class="absolute left-0 top-1/2 -translate-y-1/2 bg-white rounded-full shadow-lg p-2 hover:bg-gray-100"
                        onclick="scrollCourses('left')">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                <button class="absolute right-0 top-1/2 -translate-y-1/2 bg-white rounded-full shadow-lg p-2 hover:bg-gray-100"
                        onclick="scrollCourses('right')">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>
            </div>

            <!-- Progress Bar -->
            <div class="mt-8 bg-gray-200 rounded-full h-2">
                <div class="bg-teal-600 h-2 rounded-full" style="width: 25%"></div>
            </div>

            <!-- View Timetable Button -->
            <div class="mt-8 text-right">
                <button class="bg-teal-600 text-white px-8 py-3 rounded-lg hover:bg-teal-700 transition">
                    View Timetable
                </button>
            </div>
        </main>
    </div>

    <!-- Section Full Modal -->
    <div id="fullModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-2xl font-bold text-gray-800">Section Full</h3>
                <button onclick="closeFullModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <p class="text-gray-600 mb-6 text-center">
                The selected section is already full. Please choose a different time slot or check the timetable for available options.
            </p>
            <button onclick="closeFullModal()" 
                    class="w-full bg-teal-600 text-white py-3 rounded-lg hover:bg-teal-700 transition">
                OK
            </button>
        </div>
    </div>

    <script>
        function scrollCourses(direction) {
            const container = document.getElementById('courseContainer');
            const scrollAmount = 350;
            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }

        function showFullMessage() {
            document.getElementById('fullModal').classList.remove('hidden');
        }

        function closeFullModal() {
            document.getElementById('fullModal').classList.add('hidden');
        }

        function registerCourse(sectionId) {
            fetch('{{ route("course.register") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ course_section_id: sectionId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    if (data.message.includes('full')) {
                        showFullMessage();
                    } else {
                        alert(data.message);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }

        function unregisterCourse(sectionId) {
            if (confirm('Are you sure you want to unregister from this course?')) {
                fetch('{{ route("course.unregister") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ course_section_id: sectionId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            }
        }

        function openEditModal() {
            alert('Edit functionality - Opens modal to modify registrations');
        }
    </script>
</body>
</html>