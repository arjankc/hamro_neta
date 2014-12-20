<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>कुन दल अगाडि? (दलको तथ्यांक)</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script src="{{ URL::to('assets/js/jquery-2.0.0.min.js') }}"></script>
        <script src="{{ URL::to('assets/js/globalize.min.js') }}"></script>
        <script src="{{ URL::to('assets/js/dx.chartjs.js') }}"></script>
    </head>
    <body>
        <style>
            body {
                background: #fff;
            }
        </style>

        <script type="text/javascript">
            $(function () {
                var dataSource = [
                    @foreach ($results as $party => $votes)
                        {
                             party: "{{ $party }}",
                             votes: {{ $votes }}
                        },
                    @endforeach
                    {}
                ];

                var chart = $("#chartContainer").dxChart({
                    dataSource: dataSource,
                    rotated: true,
                    commonSeriesSettings: {
                        argumentField: "party",
                        type: "bar"
                    },
                    series: {
                        valueField: "votes",
                        name: "Votes",
                        color: "#0A49D8",
                        selectionStyle: {
                            color: "#0849D8",
                            hatching: "none"
                        }
                    },
                    title: {
                        text: "कुन दल अगाडि? (दलको तथ्यांक)"
                    },
                    legend: {
                        visible: false,
                    },
                    pointClick: function (point) {
                        point.fullState & 2 ? point.clearSelection() : point.select();
                    }
                }).dxChart("instance");
            });
        </script>
        <div id="chartContainer" style="width: 600px; height: 450px;margin:0 auto;"></div>
    </body>
</html>
