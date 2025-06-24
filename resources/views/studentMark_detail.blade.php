@extends('layout.student_form')	
@section('style')
	<link rel="stylesheet" href="{{asset('css/student_list_style.css')}}">
    @endsection

    <h1 style="margin-bottom:40px;">StudentMark Detail</h1>	
    <div class="button-container">
    <a class="studentList" href="{{route('student.list')}}">Student List</a>
    </div>	
<table>
		<tr>
			
		
			<th rowspan="2">Student ID</th>
			<th rowspan="2">StudentName</th>
			<th rowspan="2">DepartmentName</th>
			<th colspan="7">Subject</th>
			<th rowspan="2">Total</th>
			<th rowspan="2">Average</th>
		</tr>
		<tr>
			<th>Tamil</th>
			<th>English</th>
			<th>Maths</th>
			<th>Physics</th>
			<th>Chemistry</th>
			<th>Botany</th>
			<th>Zoology</th>
		</tr>
			
		

		@foreach($students as $student)
			<tr>
				<td>{{$student->id}}</td>
				<td>{{$student->first_name}}</td>
				<td>{{$student->department?->department_name}}</td>
				<td>{{$student->mark['Tamil'] ?? ''}}</td>
				<td>{{$student->mark['English'] ?? ''}}</td>
				<td>{{$student->mark['Maths'] ?? ''}}</td>
				<td>{{$student->mark['Physics'] ?? ''}}</td>
				<td>{{$student->mark['Chemistry'] ?? ''}}</td>
				<td>{{$student->mark['Botany'] ?? ''}}</td>
				<td>{{$student->mark['Zoology'] ?? ''}}</td>
				<td>{{$student->total}}</td>
				<td>{{$student->average}}</td>
			</tr>	
		@endforeach
</table>

<p>{{$students->links()}}</p>



<div class="totalStudent">
    <div class="subject">
    <h2>Tamil</h2>
    	<h3>Total: {{$subjectTotals['Tamil']}}</h3>
    	<h3>Average: {{$averageSubject['Tamil']}}</h3>
    </div>	
    <div class="subject">
    <h2>English</h2>
		<h3>Total: {{$subjectTotals['English']}}</h3>
		<h3>Average: {{$averageSubject['English']}}</h3>
	 </div>	
	<div class="subject">
	<h2>Maths</h2>
		<h3>Total: {{$subjectTotals['Maths']}}</h3>
		<h3>Average: {{$averageSubject['Maths']}}</h3>
	 </div>	
	<div class="subject">
	<h2>Physics</h2>
		<h3>Total: {{$subjectTotals['Physics']}}</h3>
		<h3>Average: {{$averageSubject['Physics']}}</h3>
	 </div>	
	<div class="subject">
	<h2>Chemistry</h2>
		<h3>Total: {{$subjectTotals['Chemistry']}}</h3>
		<h3>Average: {{$averageSubject['Chemistry']}}</h3>
	 </div>	
	<div class="subject">
	<h2>Botany</h2>
		<h3>Total: {{$subjectTotals['Botany']}}</h3>
		<h3>Average: {{$averageSubject['Botany']}}</h3>
	 </div>
	<div class="subject">
	<h2>Zoology</h2>
		<h3>Total: {{$subjectTotals['Zoology']}}</h3>
		<h3>Average: {{$averageSubject['Zoology']}}</h3>

	 </div>
		
	</div>	
