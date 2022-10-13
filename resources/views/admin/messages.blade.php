@section('plugins.Toastr', true)

<script>
    // PHP directives
    @if(session()->has('success'))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        toastr.success("{{ session('success') }}");
    @endif
</script>