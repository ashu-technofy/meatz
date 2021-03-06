//[Dashboard 2 Javascript]

//Project:	Bonito Admin - Responsive Admin Template
//Version:	1.2.0
//Last change:	10/04/2017
//Primary use:   Used only for the main dashboard 2 (index2.html)


$(function () {

  'use strict';

  /* ChartJS
   * -------
   * Here we will create a few charts using ChartJS
   */

	
 
	
  // -----------------------
  // - MONTHLY SALES CHART -
  // -----------------------

  
  // ---------------------------
  // - END MONTHLY SALES CHART -
  // ---------------------------

  
  // -----------------
  // - END PIE CHART -
  // -----------------

  /* jVector Maps
   * ------------
   * Create a world map with markers
   */


  /* SPARKLINE CHARTS
   * ----------------
   * Create a inline charts with spark line
   */

  // -----------------
  // - SPARKLINE BAR -
  // -----------------
  $('.sparkbar').each(function () {
    var $this = $(this);
    $this.sparkline('html', {
      type    : 'bar',
      height  : $this.data('height') ? $this.data('height') : '30',
      barColor: $this.data('color')
    });
  });

  // -----------------
  // - SPARKLINE PIE -
  // -----------------
  $('.sparkpie').each(function () {
    var $this = $(this);
    $this.sparkline('html', {
      type       : 'pie',
      height     : $this.data('height') ? $this.data('height') : '90',
      sliceColors: $this.data('color')
    });
  });

  // ------------------
  // - SPARKLINE LINE -
  // ------------------
  $('.sparkline').each(function () {
    var $this = $(this);
    $this.sparkline('html', {
      type     : 'line',
      height   : $this.data('height') ? $this.data('height') : '90',
      width    : '100%',
      lineColor: $this.data('linecolor'),
      fillColor: $this.data('fillcolor'),
      spotColor: $this.data('spotcolor')
    });
  });
	
}); // End of use strict
