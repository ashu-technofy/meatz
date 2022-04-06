<div class="col-lg-12 col-xl-6">
  <!-- info box -->
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title">@lang('Platform')</h3>

      <div class="box-tools pull-left">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body" style="height: 200px">
      <div class="row">
        <div class="col-lg-8 col-md-12">
          <div class="chart-responsive">
            <canvas id="pieChart" height="150"></canvas>
          </div>
          <!-- ./chart-responsive -->
        </div>
        <!-- /.col -->
        <div class="col-lg-4 col-md-12">
          <ul class="chart-legend clearfix">
            <li><i class="fab fa-android text-green"></i> @lang('Android') : {{ $platform['android'] }}</li>
            <li><i class="fab fa-apple text-black"></i> @lang('IOS') : {{ $platform['ios'] }}</li>
            <li>
              <i class="fas fa-tablet-alt text-black"></i> @lang('Number of Devices') : {{ $platform['all'] }}
            </li>
          </ul>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
  </div>
</div>
<!-- /.col -->


<script>
  console.log([
    	  {
			value    : parseInt("{{ $platform['android'] }}"),
			color    : '#7460ee',
			highlight: '#7460ee',
			label    : 'Android'
		  },
		  {
			value    : parseInt("{{ $platform['ios'] }}"),
			color    : '#000',
			highlight: '#000',
			label    : 'IOS'
		  }
  ]);
    // -------------
  // - PIE CHART -
  // -------------
  // Get context with jQuery - using jQuery's .get() method.
  var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
  var pieChart       = new Chart(pieChartCanvas);
  var PieData        = [
    	  {
			value    : parseInt("{{ $platform['android'] }}"),
			color    : '#8FB339',
			highlight: '#8FB339',
			label    : 'Android'
		  },
		  {
			value    : parseInt("{{ $platform['ios'] }}"),
			color    : '#000',
			highlight: '#000',
			label    : 'IOS'
		  }
  ];
  var pieOptions     = {
    // Boolean - Whether we should show a stroke on each segment
    segmentShowStroke    : true,
    // String - The colour of each segment stroke
    segmentStrokeColor   : '#fff',
    // Number - The width of each segment stroke
    segmentStrokeWidth   : 0,
    // Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 70, // This is 0 for Pie charts
    // Number - Amount of animation steps
    animationSteps       : 100,
    // String - Animation easing effect
    animationEasing      : 'easeOutBounce',
    // Boolean - Whether we animate the rotation of the Doughnut
    animateRotate        : true,
    // Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale         : false,
    // Boolean - whether to make the chart responsive to window resizing
    responsive           : true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio  : false,
    // String - A legend template
    legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
    // String - A tooltip template
    tooltipTemplate      : '<%=value %> <%=label%> users'
  };
  // Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
</script>