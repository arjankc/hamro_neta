<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>दलको तथ्यांक</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script src="{{ URL::to('assets/js/jquery-2.0.0.min.js') }}"></script>
        <script src="{{ URL::to('assets/js/globalize.min.js') }}"></script>
        <script src="{{ URL::to('assets/js/dx.chartjs.js') }}"></script>

        <style>
            body {
                background: #fff;
            }
        </style>

        <script type="text/javascript">
            $(function ()
                {
   var dataSource = [
    { country: "Russia", area: 12 },
    { country: "Canada", area: 7 },
    { country: "USA", area: 7 },
    { country: "China", area: 7 },
    { country: "Brazil", area: 6 },
    { country: "Australia", area: 5 },
    { country: "India", area: 2 },
    { country: "Others", area: 55 }
];

$("#chartContainer").dxPieChart({
    size:{
        width: 500
    },
    dataSource: dataSource,
    series: [
        {
            argumentField: "country",
            valueField: "area",
            label:{
                visible: true,
                connector:{
                    visible:true,
                    width: 1
                }
            }
        }
    ],
    title: "दलको तथ्यांक"
});
}

            );
        </script>

<div id="chartContainer" style="width: 600px; height: 450px;margin:0 auto;"></div>
