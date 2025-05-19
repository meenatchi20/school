
@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

@if(session('error'))
    <script>
        alert("{{ session('error') }}");
    </script>
@endif

@extends('layout.student_form')	
    
    @section('style')
	<link rel="stylesheet" href="{{asset('css/student_list_style.css')}}">
    @endsection
    @section('header')
    @include('header')
    @endsection
    @section('content')
    <!-- Search Field -->
        <h1>Students Details</h1>
    <form action="{{route('search')}}" method="GET"> 
        <div class="searchForm">
            <input type="text" name="search_firstname" id="search_firstname" class="search_field" placeholder="Search Your FirstName" value="{{$searchField['search_firstname'] ?? ''}}">
            <input type="text" name="search_lastname" id="search_lastname" placeholder="Search Your LastName" value="{{$searchField['search_lastname'] ?? ''}}">
            <input type="text" name="search_email" id="search_email" placeholder="Search Your Email"
             value="{{$searchField['search_email'] ?? ''}}">      
    
    <!-- Search Department Data -->
    <div class="department-wrapper">
            <label for="toggleDepartment" class="departmentlabel-toggle form-control">
                Select Department
            </label>
            <input type="checkbox" id="toggleDepartment" class="hiddendepartment-checkbox">
            <div class="departmentToggle-content">
                <!-- <pre>{{ print_r($searchField['department_id'] ?? 'not set', true) }}</pre> -->
                <select id="department_id" name="department_id[]" multiple>
                     @foreach($departments as $department)
                         <option value="{{$department->id}}"  {{ in_array($department->id, $searchField['department_id'] ?? []) ? 'selected' : '' }}>
                                {{$department->department_name}}
                        </option>
                    @endforeach
                </select>
            </div>
    </div>

    <!-- Search Subject Data -->
    <div class="subject-wrapper">
            <label for="toggleSubject" class="label-toggle form-control">
                 Select Subject
            </label>
            <input type="checkbox" id="toggleSubject" class="hidden-checkbox">
            <div class="toggle-content">
                <ul>
                    @foreach($subjects as $subject)
                        <li>
                            <input type="checkbox" name="subject_name[]" value="{{$subject->id}}"
                            {{ (isset($searchField['subject_name']) && in_array($subject->id, $searchField['subject_name'])) ? 'checked' : '' }}>
                            {{$subject->subject_name}}
                        </li>
                    @endforeach
                </ul>
             </div>
    </div>
            <button type="submit" value="Search" name="Search" class="search">Search</button>
            <div class="clear">
            <a href="{{ route('student.list') }}">clear</a>
            </div>
    </div>
            <div class="download-section">
                    <button type="submit" name="Pdf" value="Pdf" class="downloadpdf"><i class="fa-solid fa-download"></i>DownLoadPdf</button>
                    <a href="{{route('exceldownload')}}"  class="excelBtn"><i class="fa-solid fa-file-arrow-down"></i>Export Excel</a>
                </div>
     </form>
            
            
            <div class="importSection">
                <form action="implodeexcel" method="POST" class="importFileForm" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="student_file" class="importStudentFile">
                    <button type="submit" class="import">Import</button>
                </form>
                 
            </div>
    <table>
         <tr>
            <th>Id</th>
            <th>first_name</th>
            <th>last_name</th>
            <th>email</th>
            <th>phone number</th>
            <th>age</th>
             <th>Department</th>
            <th>Subject</th> 
            <th>Action</th>
           
        </tr>

            @foreach ($students as $student)
        <tr>
            <td> {{$student->id}} </td>
            <td> {{$student->first_name}} </td>
            <td> {{$student->last_name}} </td>
            <td> {{$student->email}} </td>
            <td> {{$student->phone_no}} </td>
            <td> {{$student->age}} </td>
            <td> {{ $student->department?->department_name }} </td>  
            <td>
                @foreach($student->subject as $subject)
                    {{ $subject->subject_name }}<br>
                @endforeach
            </td>
            <td>
                <div class="editDel">
                <a href="{{route('student.edit',$student->id)}}" class="editBtn"><i class='fa-solid fa-pencil'></i></a> 
                    <form action="{{route('student.delete',$student->id)}}" method ="POST" onclick="return confirm('Are You Sure You Want To Delete This Record?')">
                        @csrf
                        @method('DELETE')
                        <button class="button" type="submit"><i class='fa-solid fa-trash'></i></button>
                    </form>
                </div>
            </td>
           
        </tr>
             @endforeach
    </table>  
            <p> {{ $students->links() }}</p>

           
@endsection
@section('footer')
     @include('footer')
@endsection 