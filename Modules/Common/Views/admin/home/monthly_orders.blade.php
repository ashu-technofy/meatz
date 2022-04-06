<div class="row">
  <div class="col">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">@lang('Orders by services per year')</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-12 col-lg-8">
            <p class="text-center">
              <strong>{{ __("Orders: 1 Jan, :year - 30 Dec, :year" , ['year' => date('Y')]) }}</strong>
            </p>

            <div class="chart">
              <!-- Sales Chart Canvas -->
              <canvas id="salesChart" style="height: 250px;"></canvas>
            </div>
            <!-- /.chart-responsive -->
          </div>
          <!-- /.col -->
          <div class="col-md-12 col-lg-4">
            <p class="text-center">
              <strong>@lang('Orders by services per year')</strong>
            </p>
            
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- ./box-body -->
      <div class="box-footer">
        <div class="row">
          
        </div>
        <!-- /.row -->
      </div>
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->



<script>
  $.get("{{ route('admin.monthly_orders') }}" , function(result){
          var mydata = result;
          var salesChartData = {
                labels  : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'Jul' , "Aug" , 'Sep' , 'Oct' , 'Nov' , 'Dec'],
                datasets: mydata
            };
            // Get context with jQuery - using jQuery's .get() method.
  var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
  // This will get the first returned node in the jQuery collection.
  var salesChart       = new Chart(salesChartCanvas);

  

  var salesChartOptions = {
    // Boolean - If we should show the scale at all
    showScale               : true,
    // Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : true,
    // String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.1)',
    // Number - Width of the grid lines
    scaleGridLineWidth      : 0.5,
    // Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    // Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    // Boolean - Whether the line is curved between points
    bezierCurve             : true,
    // Number - Tension of the bezier curve between points
    bezierCurveTension      : 0,
    // Boolean - Whether to show a dot for each point
    pointDot                : true,
    // Number - Radius of each point dot in pixels
    pointDotRadius          : 4,
    // Number - Pixel width of point dot stroke
    pointDotStrokeWidth     : 1,
    // Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    pointHitDetectionRadius : 20,
    // Boolean - Whether to show a stroke for datasets
    datasetStroke           : true,
    // Number - Pixel width of dataset stroke
    datasetStrokeWidth      : 1,
    // Boolean - Whether to fill the dataset with a color
    datasetFill             : true,
    // String - A legend template
    legendTemplate          : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<datasets.length; i++){%><li><span style=\'background-color:<%=datasets[i].lineColor%>\'></span><%=datasets[i].label%></li><%}%></ul>',
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio     : true,
    // Boolean - whether to make the chart responsive to window resizing
    responsive              : true
  };

  // Create the line chart
  salesChart.Line(salesChartData, salesChartOptions);

      });
</script>