

<header>
    <div class="header">
    <div class="employee">
     @auth()
     @can('create',\App\Models\Student::class)
    <a class="addEmployee" href="{{route('student.create')}}">Add Students</a>
    @endcan
    @endauth
    <a  class="employeeData" href="{{route('student.list')}}"> Students List</a>
    <a href="{{route('studentmark')}}" class="studentMarkList">StudentMarkList</a>
     @auth()
     @can('sendMail', \App\Models\Student::class)
    <a href="{{route('showForm')}}" class="ContactPage">ContactPage</a>
   @endcan
    @endauth 
    </div>
    <a class="logout" href="{{route('user.logout')}}">Logout</a>
</div>
</header>