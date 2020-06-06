@if (session('success'))
<script type="text/javascript">
        $(document).ready(function(){
        	swal("Success!", "{{ session('success') }}", "success");
        });
</script>
@endif
@if (session('alert'))
<script type="text/javascript">
        $(document).ready(function(){
        	swal("Sorry!", "{{ session('alert') }}", "error");
        });
</script>
@endif
@if ($errors->any())
   <div class="alert alert-danger alert-dismissable col-md-8">
       <ul>
           @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
           @endforeach
       </ul>
   </div>
@endif