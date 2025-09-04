@auth
    <div class="d-flex">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.schools.index') }}" class="nav-link">Schools</a>
            <a href="{{ route('admin.users.index') }}" class="nav-link">Users</a>
        @endif
        
        @if(auth()->user()->isSchoolAdmin())
            <a href="{{ route('school.students.index') }}" class="nav-link">Students</a>
        @endif
        
        @if(auth()->user()->isDataEntry())
            <a href="{{ route('data.marks.create') }}" class="nav-link">Enter Marks</a>
        @endif
    </div>
@endauth