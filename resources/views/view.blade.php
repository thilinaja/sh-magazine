<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>View Magazine</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            background-color: #2e2e2e;
        }

        .solid-container {
            height: 100vh;
        }
    </style>
</head>

<body>

    <div class="flip-book-container solid-container" src="{{ $pdf }}"></div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/html2canvas.min.js"></script>
    <script src="../js/three.min.js"></script>
    <script src="../js/pdf.min.js"></script>

    <script src="../js/3dflipbook.min.js"></script>

</body>

<script>
    $(document).ready(function() {
        const interval = 15000;
        setInterval(function() {
            updateTimeOpen(15)
        }, interval);
    });

    function updateTimeOpen(interval) {
        var url = "{{ route('magazines.time', ':magazine') }}";
        url = url.replace(':magazine', '{{ $magazineId }}');

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                'time': interval,
                '_token': '{{ csrf_token() }}'
            },
            dataType: 'JSON',
        });
    }
</script>
