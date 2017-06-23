<?php
$date_data = array();
$time_data = array();

// Get file fid
$sqlFid = "SELECT fid
		   FROM user_files
		   WHERE file_name = '$filename'
		   LIMIT 1";

$result = mysqli_query($con, $sqlFid);
$row = mysqli_fetch_array($result);
$fid = $row['fid'];

$sqlFirstRowDate = "SELECT acc.date
					FROM access_log acc
					WHERE acc.fid = '$fid'
					ORDER BY acc.logid
					ASC LIMIT 1";

$sqlLastRowDate = "SELECT acc.date
				   FROM access_log acc
				   WHERE acc.fid = '$fid'
				   ORDER BY acc.logid
				   DESC LIMIT 1";

$sqlFirstRowTime = "SELECT acc.time
					FROM access_log acc
					WHERE acc.fid = '$fid'
					ORDER BY acc.logid
					ASC LIMIT 1";

$sqlLastRowTime = "SELECT acc.time
				   FROM access_log acc
				   WHERE acc.fid = '$fid'
				   ORDER BY acc.logid
				   DESC LIMIT 1";

$result = mysqli_query($con, $sqlFirstRowDate);
$row = mysqli_fetch_array($result);
$first_date_dv = $row['date'];

$result = mysqli_query($con, $sqlLastRowDate);
$row = mysqli_fetch_array($result);
$last_date_dv = $row['date'];

$result = mysqli_query($con, $sqlFirstRowTime);
$row = mysqli_fetch_array($result);
$time_start_db = $row['time'];

$result = mysqli_query($con, $sqlLastRowTime);
$row = mysqli_fetch_array($result);
$time_end_db = $row['time'];

?>

<div id="wrapper">
  <div id="sidebar-wrapper">
    <ul class="sidebar-nav">
      <li class="sidebar-brand" style="height: 28px; margin-bottom: 10px;">
        <ul class="nav nav-tabs" style="height: 28px; width: 95%; padding-top: 0px;">
          <li class="active" style="height: 28px; margin-bottom: 0px;"><a data-toggle="tab" href="#dconf" style="padding-top: 0px; padding-bottom: 0px;">Data source</a>
          </li>
          <!-- <li style="height: 28px; margin-bottom: 0px;"><a data-toggle="tab" href="#type" style="padding-top: 0px; padding-bottom: 0px;">Chart type</a></li> -->
          <li style="height: 28px; margin-bottom: 0px;"><a data-toggle="tab" href="#appearance" style="padding-top: 0px; padding-bottom: 0px;">Appearance</a>
          </li>
        </ul>
      </li>
      <li>
        <div class="tab-content">
          <div id="dconf" class="tab-pane fade in active">
            <div class="row">
              <div class="dropdown dropdown-inline" id='dropdownXbtn'>
                <a href="#" id="dropdownX" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="bounceInDown bounceInRight bounceInUp bounceInLeft">x Axis <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="termX" id="host" value="Host">Host</a>
                  </li>
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="termX" id="date" value="Date">Date</a>
                  </li>
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="termX" id="timezone" value="Timezone">Timezone</a>
                  </li>
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="termX" id="method" value="Method">Method</a>
                  </li>
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="termX" id="request" value="Request">Request</a>
                  </li>
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="termX" id="resource" value="Resource">Resource</a>
                  </li>
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="termX" id="status_code" value="Status code">StatusCode</a>
                  </li>
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="termX" id="obj_size" value="Object size">Objectsize</a>
                  </li>
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="termX" id="country" value="Country">Country</a>
                  </li>
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="termX" id="null" value="null">None</a>
                  </li>
              </div>
              <input type="text" class="daterange-input" name="daterange" id="termXdateRange" value="<?php echo $first_date_dv . ' ' . $time_start_db . ' - ' . $last_date_dv . ' ' . $time_end_db; ?>" style="display:none;" disabled/>
            </div>
            <div class="row">
              <div class="dropdown dropdown-inline" id='dropdownY1btn'>
                <a href="#" id="dropdownY1" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="bounceInDown bounceInRight bounceInUp bounceInLeft">y1 Axis <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li class="dropdown">
                    <a href="#">Host</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY1" id="host" value="Host">Host</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="count(host)" value="Count hosts">Count</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="count(distinct host)" value="Count hosts">Distinct</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">Timezone</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY1" id="timezone" value="Timezone">Timezone</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">Method</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY1" id="method" value="Method">Method</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="count(method)" value="Count method">Count</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="count(distinct method)" value="Count method">Distinct</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">Request</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY1" id="request" value="Request">Request</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="count(request)" value="Count requests">Count</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="count(distinct request)" value="Count requests">Distinct</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">Resource</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY1" id="resource" value="Resource">Resource</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="count(resource)" value="Count resource(files)">Count</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="count(distinct resource)" value="Count resource(files)">Distinct</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">StatusCode</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY1" id="status_code" value="Status code">StatusCode</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="count(status_code)" value="Count status codes">Count</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="avg(status_code)" value="Average status code">Avg</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="count(distinct status_code)" value="Average status code">Distinct</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">Objectsize</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY1" id="obj_size" value="Object size">Objectsize</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="min(obj_size)" value="Minimum object size">Min</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="max(obj_size)" value="Maximum object size">Max</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="avg(obj_size)" value="Average object size">Avg</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="sum(obj_size)" value="Sumary object size">Sum</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">Country</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY1" id="country" value="Country">Country</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="count(country)" value="Number of countries">Count</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY1" id="count(distinct country)" value="Number of countries">Distinct</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="termY1" id="null" value="null">None</a>
                  </li>
              </div>
              <div class="dropdown dropdown-inline" id="chartypeY1id">
                <a href="#" id="dropdownChartypeY1" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="bounceInDown bounceInRight bounceInUp bounceInLeft">Chart type y1 <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="chartypeY1" id="line" value="Line">Line</a>
                    <a href="javascript:void(0);" class="chartypeY1" id="spline" value="Spline">Spline</a>
                    <a href="javascript:void(0);" class="chartypeY1" id="column" value="Column">Column</a>
                    <a href="javascript:void(0);" class="chartypeY1" id="bar" value="Bar">Bar</a>
                    <a href="javascript:void(0);" class="chartypeY1" id="area" value="Area">Area</a>
                    <a href="javascript:void(0);" class="chartypeY1" id="areaspline" value="AreaSpline">Area Spline</a>
                    <a href="javascript:void(0);" class="chartypeY1" id="scatter" value="Scatter">Scatter</a>
                    <a href="javascript:void(0);" class="chartypeY1" id="pie" value="Pie">Pie</a>
                  </li>
                </ul>
              </div>
              <div id="qBuilderY1" class="qBuilder" style="display:none; width: 80%;">
                <div id="builder-y1"></div>
                <button type="button" id="btn-resetY1" class="btn btn-danger btn-xs">RESET</button>
              </div>
            </div>
            <div class="row">
              <div class="dropdown dropdown-inline" id='dropdownY2btn'>
                <a href="#" id="dropdownY2" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="bounceInDown bounceInRight bounceInUp bounceInLeft">y2 Axis <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li class="dropdown">
                    <a href="#">Host</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY2" id="host" value="Host">Host</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="count(host)" value="Count hosts">Count</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="count(distinct host)" value="Count hosts">Distinct</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">Timezone</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY2" id="timezone" value="Timezone">Timezone</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">Method</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY2" id="method" value="Method">Method</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="count(method)" value="Count method">Count</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="count(distinct method)" value="Count method">Distinct</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">Request</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY2" id="request" value="Request">Request</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="count(request)" value="Count requests">Count</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="count(distinct request)" value="Count requests">Distinct</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">Resource</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY2" id="resource" value="Resource">Resource</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="count(resource)" value="Count resource(files)">Count</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="count(distinct resource)" value="Count resource(files)">Distinct</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">StatusCode</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY2" id="status_code" value="Status code">StatusCode</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="count(status_code)" value="Count status codes">Count</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="avg(status_code)" value="Average status code">Avg</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="count(distinct status_code)" value="Count status codes">Distinct</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">Objectsize</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY2" id="obj_size" value="Object size">Objectsize</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="min(obj_size)" value="Minimum object size">Min</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="max(obj_size)" value="Maximum object size">Max</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="avg(obj_size)" value="Average object size">Avg</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="sum(obj_size)" value="Sumary object size">Sum</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="#">Country</a>
                    <ul class="dropdown-menu">
                      <li><a href="javascript:void(0);" class="termY2" id="country" value="Status code">Country</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="count(country)" value="Number of countries">Count</a>
                      </li>
                      <li><a href="javascript:void(0);" class="termY2" id="count(distinct country)" value="Number of countries">Distinct</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="termY2" id="null" value="null">None</a>
                  </li>
              </div>
              <div class="dropdown dropdown-inline" id="chartypeY2id">
                <a href="#" id="dropdownChartypeY2" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="bounceInDown bounceInRight bounceInUp bounceInLeft">Chart type y2<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="chartypeY2" id="line" value="Line">Line</a>
                    <a href="javascript:void(0);" class="chartypeY2" id="spline" value="Spline">Spline</a>
                    <a href="javascript:void(0);" class="chartypeY2" id="column" value="Column">Column</a>
                    <a href="javascript:void(0);" class="chartypeY2" id="bar" value="Bar">Bar</a>
                    <a href="javascript:void(0);" class="chartypeY2" id="area" value="Area">Area</a>
                    <a href="javascript:void(0);" class="chartypeY2" id="areaspline" value="AreaSpline">Area Spline</a>
                    <a href="javascript:void(0);" class="chartypeY2" id="scatter" value="Scatter">Scatter</a>
                    <a href="javascript:void(0);" class="chartypeY2" id="pie" value="Pie">Pie</a>
                  </li>
                </ul>
              </div>
              <div id="qBuilderY2" class="qBuilder" style="display:none; width: 80%;">
                <div id="builder-y2"></div>
                <button type="button" id="btn-resetY2" class="btn btn-danger btn-xs">RESET</button>
              </div>
            </div>
          </div>
          <div id="type" class="tab-pane fade">
            <div class="row" style="margin-left: 0px; margin-right: 0px; height: 34px;">
            </div>
            <div class="row" style="margin-left: 0px; margin-right: 0px; height: 34px;">
            </div>
          </div>
          <div id="appearance" class="tab-pane fade">
            <div class="row" style="margin-left: 0px; margin-right: 0px; height: 34px;">
              <span><b>Data Labels     </b></span>
              <input id="dataLabels-toggle" class="dataLabels-toggle" unchecked data-toggle="toggle" data-on="On" data-off="Off" data-onstyle="success" data-size="mini" data-offstyle="warning" type="checkbox">
            </div>
            <span><b>Dash style</b></span>
            <div class="row" style="margin-left: 0px; margin-right: 0px; height: 34px;">
              <div class="dropdown dropdown-inline" id='dropdownDashStyleDivY1'>
                <a href="#" id="dropdowndashStyleY1" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="bounceInDown bounceInRight bounceInUp bounceInLeft">Dash style y1<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="dashStyleY1" id="solid" value="Solid">Solid</a>
                    <a href="javascript:void(0);" class="dashStyleY1" id="shortDot" value="ShortDot">ShortDot</a>
                    <a href="javascript:void(0);" class="dashStyleY1" id="shortDash" value="ShortDash">ShortDash</a>
                    <a href="javascript:void(0);" class="dashStyleY1" id="shortDashDot" value="ShortDashDot">ShortDashDot</a>
                    <a href="javascript:void(0);" class="dashStyleY1" id="shortDashDotDot" value="ShortDashDotDot">ShortDashDotDot</a>
                    <a href="javascript:void(0);" class="dashStyleY1" id="dot" value="Dot">Dot</a>
                    <a href="javascript:void(0);" class="dashStyleY1" id="dash" value="Dash">Dash</a>
                    <a href="javascript:void(0);" class="dashStyleY1" id="dashDot" value="DashDot">DashDot</a>
                    <a href="javascript:void(0);" class="dashStyleY1" id="longDashDot" value="LongDashDot">LongDashDot</a>
                    <a href="javascript:void(0);" class="dashStyleY1" id="longDashDotDot" value="LongDashDotDot">LongDashDotDot</a>
                    <a href="javascript:void(0);" class="dashStyleY1" id="longDash" value="Long dash">Long dash</a>
                  </li>
                </ul>
              </div>
              <div class="dropdown dropdown-inline" id='dropdownDashStyleDivY2'>
                <a href="#" id="dropdowndashStyleY2" class="btn btn-default dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-animations="bounceInDown bounceInRight bounceInUp bounceInLeft">Dash style y2<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li class="dropdown">
                    <a href="javascript:void(0);" class="dashStyleY2" id="solid" value="Solid">Solid</a>
                    <a href="javascript:void(0);" class="dashStyleY2" id="shortDot" value="ShortDot">ShortDot</a>
                    <a href="javascript:void(0);" class="dashStyleY2" id="shortDash" value="ShortDash">ShortDash</a>
                    <a href="javascript:void(0);" class="dashStyleY2" id="shortDashDot" value="ShortDashDot">ShortDashDot</a>
                    <a href="javascript:void(0);" class="dashStyleY2" id="shortDashDotDot" value="ShortDashDotDot">ShortDashDotDot</a>
                    <a href="javascript:void(0);" class="dashStyleY2" id="dot" value="Dot">Dot</a>
                    <a href="javascript:void(0);" class="dashStyleY2" id="dash" value="Dash">Dash</a>
                    <a href="javascript:void(0);" class="dashStyleY2" id="dashDot" value="DashDot">DashDot</a>
                    <a href="javascript:void(0);" class="dashStyleY2" id="longDashDot" value="LongDashDot">LongDashDot</a>
                    <a href="javascript:void(0);" class="dashStyleY2" id="longDashDotDot" value="LongDashDotDot">LongDashDotDot</a>
                    <a href="javascript:void(0);" class="dashStyleY2" id="longDash" value="Long dash">Long dash</a>
                  </li>
                </ul>
              </div>
            </div>
            <br>
            <span><b>Line color</b></span>
            <div class="row" style="margin-left: 0px; margin-right: 0px; height: 34px;">
              <span><b>y1</b></span>
              <input type='text' id="y1Color" />
              <span><b>y2</b></span>
              <input type='text' id="y2Color" />
            </div>
            <span><b>Background color</b></span>
            <div class="row" style="margin-left: 0px; margin-right: 0px; height: 34px;">
              <input type='text' id="bgColor" />
            </div>
          </div>
      </li>
      </ul>
      </div>
      <div id="graphPanel" class="panel panel-default" style="margin-bottom: 0px;">
        <div class="panel-body">
          <div class="row" style="padding: 5px;">
            <div>
              <a href="#menu-toggle" class="btn btn-default glyphicon glyphicon-cog" id="menu-toggle"></a>
            </div>
            <div>
              <button type="button" id="MainApplyBtn" class="btn btn-info btn-lg btn-block">Apply</button>
            </div>
            <div>
              <button type="button" id="saveGraphBtn" class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#saveGraphModal">Save</button>
            </div>
            <div>
              <button type="button" id="viewTableY1Btn" class="btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#viewTableY1Modal" disabled>Y1 Data</button>
            </div>
            <div>
              <button type="button" id="viewTableY2Btn" class="btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#viewTableY2Modal" disabled>Y2 Data</button>
            </div>
          </div>
          <div id="graphWrapper" style="display:none;">
            <div id="dynamicChart" style=""></div>
            <!-- canvas tag to convert chart SVG -->
            <canvas id="canvas" style="display:none;"></canvas>
          </div>
        </div>
      </div>
  </div>
  <div id="saveGraphModal" class="modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Save graph</h4>
        </div>
        <div class="modal-body">
          <p>Graph name:</p>
          <input type="text" class="form-control" id="graph-name" maxlength="50">
          <p>Comments:</p>
          <textarea class="form-control" rows="2" id="graph-comment" maxlength="100"></textarea>
        </div>
        <div class="modal-footer">
          <button id='saveBtn' class="btn btn-success" id="modal-btn-save glyphicon glyphicon-floppy-save">Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div id="viewTableY1Modal" class="modal" role="dialog">
    <div id="viewTableY1Modal-dialog" class="modal-dialog">
      <div id="viewTableY1Modal-content" class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Table Y1 view</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table id="data-tableY1" class="table table-borderless table-condensed table-hover" style="display:none;width: 100%;">
                <thead>
                  <tr>
                    <th>x Axis</th>
                    <th>y1 Axis</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- modal -->
  <!-- Modal -->
  <div id="viewTableY2Modal" class="modal" role="dialog">
    <div id="viewTableY2Modal-dialog" class="modal-dialog">
      <!-- Modal content-->
      <div id="viewTableY2Modal-content" class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Table Y2 view</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <table id="data-tableY2" class="table table-borderless table-condensed table-hover" style="display:none;width: 100%;">
                <thead>
                  <tr>
                    <th>x Axis</th>
                    <th>y2 Axis</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- modal -->

<script type="text/javascript" charset="utf-8">
// global chart object
// var chart = $('#dynamicChart').highcharts();

var fieldPickerObj = {
  "xAxis": null,
  "y1Axis": null,
  "y2Axis": null,
  "startDate": null,
  "endDate": null,
  "timeStarts": null,
  "timeEnds": null,
  "whereY1": null,
  "whereY2": null,
	"JSONwhereY1": null,
	"JSONwhereY2": null,
  "chartypeY1": null,
  "chartypeY2": null,
  "y1LineColor": '#7cb4eb',
  "y2LineColor": '#46474b',
  "showLabels": false,
  "dashStyleY1": null,
  "dashStyleY2": null,
  "backColor": '#fff',
};

var startDateDB;
var endDateDB;

// For preventing the user to select date bigger than the log files
var minDateDB = '<?php echo $first_date_dv;?>';
var maxDateDB = '<?php echo $last_date_dv;?>';
var chartypeY1 = 'line';
var chartypeY2 = 'line';
var dashStyleY1 = 'solid';
var dashStyleY2 = 'solid';
var backColor = '#fff';

// Is true when user clicks on point to zoom in graph
var drilled = false;

// Helper for adjusting the graph on resising and side bar open/close
var graphGenerated = false;

$(function () {
  // Used for getting data for the graph the user wants to edit
  if (getQueryVariable("action") === 'edit') {
    console.log('Loading graph...');
    var graphName = getQueryVariable("name");
    var uid = getQueryVariable("user");
    var fname = getQueryVariable("fname");

    loadGraph(graphName, uid, fname);

  } else {
    console.log('Creating new graph...');

    var startDateDB = '<?php echo $first_date_dv;?>';
    var endDateDB = '<?php echo $last_date_dv;?>';
  }
  //On page load call the function setDynamicChart
	setDynamicChart(chartypeY1);
});


// If user tries to load graph the var 'edit' will be at the url. To get anchor var from end of url
function getQueryVariable(variable) {
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i = 0; i < vars.length; i++) {
    var pair = vars[i].split("=");
    if (pair[0] == variable) {
      return pair[1];
    }
  }
  return (false);
}

// Date-time picker object
$('input[name="daterange"]').daterangepicker({
  locale: {
    format: 'YYYY-MM-DD HH:mm:ss'
  },
  "showDropdowns": true,
  "timePicker": true,
  "timePicker24Hour": true,
  "timePickerSeconds": true,
  "linkedCalendars": false,
  "autoUpdateInput": false,
  "showCustomRangeLabel": false,
  "alwaysShowCalendars": true,
  "startDate": startDateDB,
  "endDate": endDateDB,
  "minDate": minDateDB,
  "maxDate": maxDateDB
}, function (start, end, label) {
  fieldPickerObj.startDate = start.format('YYYY-MM-DD');
  fieldPickerObj.endDate = end.format('YYYY-MM-DD');

  // If user does not select date range return null
  // If user did't set time set fieldPickerObj.timeStarts && .timeEnds to null
  if (start.format('HH:mm:ss') == '00:00:00' || end.format('HH:mm:ss') == '00:00:00') {
    fieldPickerObj.timeStarts = null;
    fieldPickerObj.timeEnds = null;
  }
});

$('#MainApplyBtn').button().click(function (chart) {

  // Modifing apply btn text set to back/apply and set size
  if (drilled === true) {
    $('#MainApplyBtn').html('Apply');
    // Change padding for the text to fit
    $('#MainApplyBtn').css({
      "padding-right": "60px"
    });
    drilled = false;
  }

  // Get where clause from query builders
  var whereY1 = $('#builder-y1').queryBuilder('getSQL', false);
  var whereY2 = $('#builder-y2').queryBuilder('getSQL', false);


  // If user has selected options for where
  if (whereY1.sql.length > 2) {
    fieldPickerObj.whereY1 = whereY1.sql;
  }
  if (whereY2.sql.length > 2) {
    fieldPickerObj.whereY2 = whereY2.sql;
  }

   //For storing the query in json so if user wants to edit graph I can
   //load the query to the query builders
   var resultWhereY1 = $('#builder-y1').queryBuilder('getRules');
   if (!$.isEmptyObject(resultWhereY1)) {
	  fieldPickerObj.JSONwhereY1 = JSON.stringify(resultWhereY1, null, 2);
   }

   var resultWhereY2 = $('#builder-y2').queryBuilder('getRules');
   if (!$.isEmptyObject(resultWhereY2)) {
	  fieldPickerObj.JSONwhereY2 = JSON.stringify(resultWhereY2, null, 2);
   }

  if (fieldPickerObj.xAxis !== null && fieldPickerObj.y1Axis !== null || fieldPickerObj.y2Axis !== null) {

    $('#dynamicChart').show(500);

    if (fieldPickerObj.xAxis == 'date') {
      updateGraph(chart, fieldPickerObj, true, 'dynamicChart');

    } else {
      updateGraph(chart, fieldPickerObj, false, 'dynamicChart');
    }

  } else {
    console.log("Null fieldPickerObj");
    alert("x or y axis found null");
  }
});

// Gets the values set on modal and fires ajax query to insert graph configuration to database
$("#saveBtn").click(function () {
  var uid = '<?php echo $uid; ?>';
  var filename = '<?php echo $filename; ?>';
  var chartName = $('#graph-name').val();
  var graphComments = $('#graph-comment').val();

  // SVG conversion for saving img
  var svg = document.getElementById('dynamicChart').children[0].innerHTML;
  canvg(document.getElementById('canvas'), svg);
  var img = canvas.toDataURL("image/png"); //img is data:image/png;base64
  img = img.replace('data:image/png;base64,', '');
  var imagedata = "bin_data=" + img;

  if (chartName ? true : alert('Chart name not set.')) {

    $.ajax({
      type: "POST",
      url: "./pages/statistics/runQuery.php",
      data: {
        action: 'saveGraph',
        first: uid,
        second: filename,
        third: chartName,
        forth: graphComments,
        fifth: fieldPickerObj,
        image: imagedata
      },
      dataType: "text",
      success: function (response) {
        //console.debug('save Ajax response:' + response);
        $('#saveGraphModal').modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
      },
    });
  }
});

//
// $('.termX').click(function () {
//   adjust(this);
// });

function adjustXcomponent(xAxis) {
	$("#dropdownX").text(capitalizeFirstLetter(xAxis));

	// If fields has Date show datepicker else hide it
	if ($('#dropdownX').text().indexOf('Date') != -1) {
		$('#col-md-6-date').show(500);
		$('#termXdateRange').prop({
			disabled: false
		});
		$('#termXdateRange').show(500);
	} else {
		$('#col-md-6-date').hide(500);
		$('#termXdateRange').prop({
			disabled: true
		});
		$('#termXdateRange').hide(500);
	}
}

function adjustY1component(y1Axis) {
	if (y1Axis !== 'NULL') {
	  $("#dropdownY1").text(capitalizeFirstLetter(y1Axis));

		// If field has something show qBuilder
	  if (fieldPickerObj.y1Axis == 'null') {
	    $('#qBuilderY1').hide(500);
	  } else {
	    $('#qBuilderY1').show(500);
	  }
	}
}

function adjustY2component(y2Axis) {
	if (y2Axis !== 'NULL') {
	  $("#dropdownY2").text(capitalizeFirstLetter(y2Axis));

		// If field has something show qBuilder
	  if (fieldPickerObj.y2Axis == 'null') {
	    $('#qBuilderY2').hide(500);
	  } else {
	    $('#qBuilderY2').show(500);
	  }
	}
}

function adjustChartypeY1(chartypeY1) {
	if (chartypeY1 !== 'line') {
		$("#dropdownChartypeY1").text(capitalizeFirstLetter(chartypeY1));

		// If chart is pie disable color picker and date attr on dropdownX
		if ($('#dropdownChartypeY1').text().indexOf('Pie') != -1) {

			// Disable chartypeY2 if pie selected
      $("#dropdownY2").hide(500);
			$("#dropdownChartypeY2").hide(500);
			$("#y1Color").spectrum("disable");
			$("#y2Color").spectrum("disable");
			$("#bgColor").spectrum("disable");
			$('#dashStyleY1').prop({
				disabled: false
			});
			$('#dashStyleY2').prop({
				disabled: false
			});
			$("#date").css("display", "none");
		} else {
			$("#dropdownY2").show(500);
      $("#dropdownChartypeY2").show(500);
			$("#y1Color").spectrum("enable");
			$("#y2Color").spectrum("enable");
			$("#bgColor").spectrum("enable");
			$('#dashStyleY1').prop({
				disabled: true
			});
			$('#dashStyleY2').prop({
				disabled: true
			});
			$("#date").css("display", "initial");
		}
	} else {
    $("#dropdownChartypeY1").text('Line');
  }
}

function adjustChartypeY2(chartypeY2) {
	if (chartypeY2 !== 'line') {
		$("#dropdownChartypeY2").text(capitalizeFirstLetter(chartypeY2));

		// If chart is Line or splice enable dash style
		if ($('#dropdownChartypeY2').text().indexOf('Line') != -1 || $('#dropdownChartypeY2').text().indexOf('Spline') != -1) {
			$('#dropdownDashStyleDivY2').prop({
				disabled: false
			});
		} else {
			$('#dropdownDashStyleDivY2').prop({
				disabled: true
			});
		}

		// If chart is pie disable color picker and date attr on dropdownX
		if ($('#dropdownChartypeY2').text().indexOf('Pie') != -1) {
			// Disable chartypeY2 if pie selected
			$("#dropdownY1").hide(500);
      $("#dropdownChartypeY1").hide(500);
			$("#y1Color").spectrum("disable");
			$("#y2Color").spectrum("disable");
			$("#bgColor").spectrum("disable");
			$('#dashStyleY1').prop({
				disabled: false
			});
			$('#dashStyleY2').prop({
				disabled: false
			});
			$("#date").css("display", "none");
		} else {
			$("#dropdownY1").show(500);
      $("#dropdownChartypeY1").show(500);
			$("#y1Color").spectrum("enable");
			$("#y2Color").spectrum("enable");
			$("#bgColor").spectrum("enable");
			$('#dashStyleY1').prop({
				disabled: true
			});
			$('#dashStyleY2').prop({
				disabled: true
			});
			$("#date").css("display", "initial");
		}
	} else {
    $("#dropdownChartypeY2").text('Line');
  }
}

function adjustDashStyleY1 (dashStyleY1) {
	if (dashStyleY1 !== 'solid') {
		$("#dropdowndashStyleY1").text(capitalizeFirstLetter(dashStyleY1));
	}
}

function adjustDashStyleY2 (dashStyleY2) {
	if (dashStyleY2 !== 'solid') {
		$("#dropdowndashStyleY2").text(capitalizeFirstLetter(dashStyleY2));
	}
}

function adjustY1Linecolor (y1LineColor) {
	if (y1LineColor !== '#46474b') {
		$("#y1Color").spectrum("set", y1LineColor);
	}
}

function adjustY2Linecolor (y2LineColor) {
	if (y2LineColor !== '#7cb4eb') {
		$("#y2Color").spectrum("set", y2LineColor);
	}
}

function adjustBackColor (backColor) {
	if (backColor !== '#fff') {
		$("#bgColor").spectrum("set", backColor);
	}
}

function adjustToggle(labels) { 
  // labels == 1 means that the saved graph has showlabels on (this code is very buggy)
	if (labels === false || labels == 1) {
	  $('#toggle-trigger').bootstrapToggle('on');
    fieldPickerObj.showLabels = true;
	} else {
	  $('#toggle-trigger').bootstrapToggle('off');
    fieldPickerObj.showLabels = false;
	}
}
// function adjustToggle() {
//   if (fieldPickerObj.showLabels === 'true') {
//     fieldPickerObj.showLabels = true;
//     $(".dataLabels-toggle").prop('checked', true).change();
//   } else {
//     fieldPickerObj.showLabels = false;
//     $(".dataLabels-toggle").prop('checked', false).change();
//   }
// }
function loadGraph(graphName, uid, fname) {
  // Get saved graph data
  $.ajax({
    type: "POST",
    url: "/loganal/lib/ajaxRequests.php",
    data: {
      action: 'editGraph',
      name: graphName,
      user: uid,
      filename: fname
    },
    dataType: "json",
    success: function (data) {
			loadConf(data);
    }
  });
	// For showing the graph after the page has loaded and values are set
	setTimeout(function(){
  	$('#MainApplyBtn').click();
  }, 1000);
}

function loadConf(data) { //loop???

	// Value setup when user is editing a graph
	fieldPickerObj.xAxis = data[0]['termX'];
	fieldPickerObj.y1Axis = data[0]['termY1'];
	fieldPickerObj.y2Axis = data[0]['termY2'];
	fieldPickerObj.startDate = data[0]['StartDate'];
	fieldPickerObj.endDate = data[0]['EndDate'];
	fieldPickerObj.timeStarts = data[0]['StartTime'];
	fieldPickerObj.timeEnds = data[0]['EndTime'];
	fieldPickerObj.selectedDate = data[0]['DrillDate'];
	fieldPickerObj.chartypeY1 = data[0]['chartypeY1'];
	fieldPickerObj.chartypeY2 = data[0]['chartypeY2'];
	fieldPickerObj.dashStyleY1 = data[0]['dashStyleY1'];
	fieldPickerObj.dashStyleY2 = data[0]['dashStyleY2'];
	fieldPickerObj.y1LineColor = data[0]['y1LineColor'];
	fieldPickerObj.y2LineColor = data[0]['y2LineColor'];
	fieldPickerObj.backColor = data[0]['BackColor'];
	fieldPickerObj.showLabels = data[0]['ShowLabels'];

	console.log('fieldPickerObj SET. now adjust');
	console.log(fieldPickerObj);
	adjustXcomponent(fieldPickerObj.xAxis);
	adjustY1component(fieldPickerObj.y1Axis);
	adjustY2component(fieldPickerObj.y2Axis);
	adjustChartypeY1(fieldPickerObj.chartypeY1);
	adjustChartypeY2(fieldPickerObj.chartypeY2);
	adjustDashStyleY1(fieldPickerObj.dashStyleY1);
	adjustDashStyleY2(fieldPickerObj.dashStyleY2);
	adjustY1Linecolor(fieldPickerObj.y1LineColor);
	adjustY2Linecolor(fieldPickerObj.y2LineColor);
	adjustBackColor(fieldPickerObj.backColor);
	adjustToggle(fieldPickerObj.showLabels);

	console.log('adjusted components');
	console.log(fieldPickerObj);

	if (data[0]['JSONwhereY1'] !== null) {
		console.log(data[0]['JSONwhereY1']);
		$('#builder-y1').queryBuilder('setRules', data[0]['JSONwhereY1']);
	}
	
	if (data[0]['JSONwhereY2'] !== null) {
		console.log(data[0]['JSONwhereY2']);
		$('#builder-y2').queryBuilder('setRules', data[0]['JSONwhereY2']);
	}

	//   // Set data to query builder OLD!
	// https://www.npmjs.com/package/sql-parser-mistic
	// if (comp[0] === 'WhereY1') {
	//   if (comp[1] !== 'null') {
	//     console.log('[Parser]:Parsing ' + comp[1]);
	//     $('#builder-y1').queryBuilder('setRulesFromSQL', comp[1]);
	//   }
	// }
	
	// Set data to query builder
	// if (comp[0] === 'WhereY2') { console.debug(comp[0] + " " + comp[1]);
	//   if (comp[1] !== 'null') {
		//	console.log('[Parser]:Parsing ' + comp[1]);
	//    $('#builder-y2').queryBuilder('setRulesFromSQL', comp[1]);
	//   }
	// }
}


// If user clicks on a field of dropdown1, get id of field and put it to var and change dropdown1 text()
// Field picker obj values when user is creating graph are stored from here to the object.
$('.termX').click(function () {
	fieldPickerObj.xAxis = $(this).attr('id');
	adjustXcomponent(fieldPickerObj.xAxis);
});

// If user clicks on a field of dropdown2, get id of field and put it to var and change dropdown2 text()
$('.termY1').click(function () {
	fieldPickerObj.y1Axis = $(this).attr('id');
	adjustY1component(fieldPickerObj.y1Axis);
});

// If user clicks on a field of dropdown3, get id of field and put it to var and change dropdown3 text()
$('.termY2').click(function () {
	fieldPickerObj.y2Axis = $(this).attr('id');
	adjustY2component(fieldPickerObj.y2Axis);
});

$('.chartypeY1').click(function () {
	fieldPickerObj.chartypeY1 = $(this).attr('id');
	adjustChartypeY1(fieldPickerObj.chartypeY1);
});

$('.chartypeY2').click(function () {
	fieldPickerObj.chartypeY2 = $(this).attr('id');
	adjustChartypeY2(fieldPickerObj.chartypeY2);
});

$('.dashStyleY1').click(function () {
	fieldPickerObj.dashStyleY1 = $(this).attr('id');
	adjustDashStyleY1(fieldPickerObj.dashStyleY1);
});

$('.dashStyleY2').click(function () {
	fieldPickerObj.dashStyleY2 = $(this).attr('id');
	adjustDashStyleY2(fieldPickerObj.dashStyleY2);
});

$('.dataLabels-toggle').change(function () {
		adjustToggle(fieldPickerObj.showLabels);
});

/**
 * applyBtn = Date picker apply btn
 * [left datetime, right datetime description]
 * Cut each string at space, return array with two values
 * one for date one for time. Doing this because the plugin
 * is buggy
 */
$('.applyBtn').click(function () {
  setDateTimeBox();
});

// Color picker y1
$("#y1Color").spectrum({
  color: "7cb4eb",
  allowEmpty: true,
  showPaletteOnly: true,
  showPalette: true,
  palette: [
    ['7cb4eb', 'black', '46474b', 'blanchedalmond',
      'rgb(255, 128, 0);', 'hsv 100 70 50', '200080'
    ],
    ['red', 'yellow', 'green', 'blue', 'violet', '800000', '42f4e2']
  ],
  change: function (tinycolor) {
    // Get value from colorPicker
    rgbY1 = $("#y1Color").val();

    // Parse rbg string value [rgb(0, 0, 255)]
    rgbY1 = rgbY1.substring(4, rgbY1.length - 1)
      .replace(/ /g, '')
      .split(',');

    // Set color to fieldPickerObj. Used for saving.
    fieldPickerObj.y1LineColor = rgb2hex(rgbY1[0], rgbY1[1], rgbY1[2]);

  },
});


// Color picker y2
$("#y2Color").spectrum({
  color: "46474b",
  allowEmpty: true,
  showPaletteOnly: true,
  showPalette: true,
  palette: [
    ['7cb4eb', 'black', '46474b', 'blanchedalmond',
      'rgb(255, 128, 0);', 'hsv 100 70 50', '200080'
    ],
    ['red', 'yellow', 'green', 'blue', 'violet', '800000', '42f4e2']
  ],
  change: function (tinycolor) {
    // // Get value from colorPicker
    rgbY2 = $("#y2Color").val();

    // Parse rbg string value [rgb(68, 128, 38)]
    rgbY2 = rgbY2.substring(4, rgbY2.length - 1)
      .replace(/ /g, '')
      .split(',');

    // Set color to fieldPickerObj. Used for saving.
    fieldPickerObj.y2LineColor = rgb2hex(rgbY2[0], rgbY2[1], rgbY2[2]);
  },
});

// Color picker backgroundcolor
$("#bgColor").spectrum({
  color: "fff",
  allowEmpty: true,
  showPaletteOnly: true,
  showPalette: true,
  palette: [
    ['fff', 'black', '46474b', 'blanchedalmond',
      'rgb(255, 128, 0);', 'hsv 100 70 50', '200080'
    ],
    ['red', 'yellow', 'green', 'blue', 'violet', '800000', '42f4e2']
  ],
  change: function (tinycolor) {
    // // Get value from colorPicker
    rgbY2 = $("#bgColor").val();

    // Parse rbg string value [rgb(68, 128, 38)]
    rgbY2 = rgbY2.substring(4, rgbY2.length - 1)
      .replace(/ /g, '')
      .split(',');

    // Call convertion method.
    backColor = rgb2hex(rgbY2[0], rgbY2[1], rgbY2[2]);

    //  Set color to fieldPickerObj. Used for saving.
    fieldPickerObj.backColor = backColor;
  },
});

// Method converter rgb=>hex
function rgb2hex(red, green, blue) {
  var rgb = blue | (green << 8) | (red << 16);
  return '#' + (0x1000000 + rgb).toString(16).slice(1);
}


$('#btn-resetY1').on('click', function () {
  $('#builder-y1').queryBuilder('reset');
});

$('#btn-resetY2').on('click', function () {
  $('#builder-y2').queryBuilder('reset');
});

// After a rule has been deleted set null the where value of fieldPickerObject
// fieldPickerObj must be outside of the $.function() for this to work
$('#builder-y1').on('afterDeleteRule.queryBuilder', function (e, rule, error, value) {
  fieldPickerObj.whereY1 = null;
});


// After a rule has been deleted set null the where value of fieldPickerObject
// fieldPickerObj must be outside of the $.function() for this to work
$('#builder-y2').on('afterDeleteRule.queryBuilder', function (e, rule, error, value) {
  fieldPickerObj.whereY2 = null;
});

//==================================
//-----Graph functions
//==================================

//function is created so we pass the value dynamically and be able to refresh the HighCharts on every click
function setDynamicChart(chartype) {
  var chart = $('#dynamicChart').highcharts();
  $('#graphWrapper').show(function () { // Used for rendering the graph at the right size
    $('#dynamicChart').highcharts({
      // legend: {
      //   symbolWidth: 60
      // },
      title: {
        text: ''
      },
      // tooltip: {
      //   shared: true
      // },
      // series: [{
      //   data: [null],
      // }],
      // responsive: {
      //   rules: [{
      //     condition: {
      //       maxWidth: 1680
      //     },
      //     chartOptions: {
      //       legend: {
      //         //enabled: false
      //       }
      //     }
      //   }]
      // }
    });
  });
}

function updateGraph(chart, fieldPickerObj, hasDate, renderDiv) {
	console.debug('INSIDE UPDATE GRAPH AJAX');
	console.debug(fieldPickerObj.showLabels);

  // Graph shown
  graphGenerated = true;

  // Enable view table btn
  if (graphGenerated) {
    if (fieldPickerObj.y1Axis !== null && fieldPickerObj.y1Axis !== undefined && fieldPickerObj.y1Axis !== 'null') {
      $('#viewTableY1Btn').prop({
        disabled: false
      });
    } else {
      $('#viewTableY1Btn').prop({
        disabled: true
      });
    }

    if (fieldPickerObj.y2Axis !== null && fieldPickerObj.y2Axis !== undefined && fieldPickerObj.y2Axis !== 'null') {
      $('#viewTableY2Btn').prop({
        disabled: false
      });
    } else {
      $('#viewTableY2Btn').prop({
        disabled: true
      });
    }
  }

  // Init vars
  var uid = '<?php echo $uid; ?>';
  var filename = '<?php echo $filename; ?>';
  var options;
  var title = formatTitle(fieldPickerObj);

  // Clean object
  clean(fieldPickerObj);

  if (hasDate) {
options = {
  chart: {
	renderTo: renderDiv,
	backgroundColor: fieldPickerObj.backColor,
	//type: chartype,
	zoomType: 'xy'
  },
  title: {
	text: title
  },
  xAxis: {
	type: 'datetime',
  },
  yAxis: [{ // Primary yAxis
	title: {
	  text: fieldPickerObj.y1Axis
	},
  }, { // Secondary yAxis
	title: {
	  text: fieldPickerObj.y2Axis
	},
	opposite: true,
  }],
  tooltip: {
	shared: true
  },
  plotOptions: {
    series: {
          turboThreshold: 15000 //set it to a larger threshold, it is by default to 1000
        },
	line: {
	  dataLabels: {
		enabled: fieldPickerObj.showLabels
	  },
	  cursor: 'pointer',
	  point: {
		events: {
		  click: function () {
			drill(uid, filename, options, fieldPickerObj, this.x);
		  }
		}, // events
	  } // point
	}, // line
	spline: {
	  dataLabels: {
		enabled: fieldPickerObj.showLabels
	  },
	  cursor: 'pointer',
	  point: {
		events: {
		  click: function () {
			drill(uid, filename, options, fieldPickerObj, this.x);
		  }
		}, // events
	  } // point
	}, // spline
	column: {
	  dataLabels: {
		enabled: fieldPickerObj.showLabels
	  },
	  cursor: 'pointer',
	  point: {
		events: {
		  click: function () {
			drill(uid, filename, options, fieldPickerObj, this.x);
		  }
		}, // events
	  } // point
	}, // column
	bar: {
	  dataLabels: {
		enabled: fieldPickerObj.showLabels
	  },
	  cursor: 'pointer',
	  point: {
		events: {
		  click: function () {
			drill(uid, filename, options, fieldPickerObj, this.x);
		  }
		}, // events
	  } // point
	}, // bar
	area: {
	  dataLabels: {
		enabled: fieldPickerObj.showLabels
	  },
	  cursor: 'pointer',
	  point: {
		events: {
		  click: function () {
			drill(uid, filename, options, fieldPickerObj, this.x);
		  }
		}, // events
	  } // point
	}, // area
	areaspline: {
	  dataLabels: {
		enabled: fieldPickerObj.showLabels
	  },
	  cursor: 'pointer',
	  point: {
		events: {
		  click: function () {
			drill(uid, filename, options, fieldPickerObj, this.x);
		  }
		}, // events
	  } // point
	}, // area
	scatter: {
	  dataLabels: {
		enabled: fieldPickerObj.showLabels
	  },
	  cursor: 'pointer',
	  point: {
		events: {
		  click: function () {
			drill(uid, filename, options, fieldPickerObj, this.x);
		  }
		}, // events
	  } // point
	}, // scatter
  }, // plotOptions

  series: []

}; // options

  } else {
    options = {
      chart: {
        renderTo: renderDiv,
        backgroundColor: fieldPickerObj.backColor,
        zoomType: 'xy',
      },
      title: {
        text: formatTitle(fieldPickerObj)
      },
      xAxis: {
        type: 'category'
      },
      yAxis: [{ // Primary yAxis
        title: {
          text: fieldPickerObj.y1Axis
        }
      }, { // Secondary yAxis
        title: {
          text: fieldPickerObj.y2Axis
        },
        opposite: true,
      }],
      tooltip: {
        shared: true
      },
      plotOptions: {
        series: {
          turboThreshold:15000 //set it to a larger threshold, it is by default to 1000
        },
        line: {
          dataLabels: {
            enabled: fieldPickerObj.showLabels
          },
        },
        spline: {
          dataLabels: {
            enabled: fieldPickerObj.showLabels
          },
        },
        column: {
          dataLabels: {
            enabled: fieldPickerObj.showLabels
          },
        },
        bar: {
          dataLabels: {
            enabled: fieldPickerObj.showLabels
          },
        },
        area: {
          dataLabels: {
            enabled: fieldPickerObj.showLabels
          },
        },
        areaspline: {
          dataLabels: {
            enabled: fieldPickerObj.showLabels
          },
        },
        scatter: {
          dataLabels: {
            enabled: fieldPickerObj.showLabels
          },
        },
      }, // plot options
      series: {},
    };
  }

  $.ajax({
    type: "POST",
    url: "./pages/statistics/runQuery.php",
    data: {
      action: 'execute',
      first: uid,
      second: filename,
      third: JSON.stringify(fieldPickerObj)
    },
    dataType: "json",
    success: function (response) {

      if (response[1].length > 0) {
        options.series = [{
          type: fieldPickerObj.chartypeY1,
          name: fieldPickerObj.y1Axis,
          color: fieldPickerObj.y1LineColor,
          data: response[0],
          dashStyle: fieldPickerObj.dashStyleY1
        }, {
          type: fieldPickerObj.chartypeY2,
          name: fieldPickerObj.y2Axis,
          color: fieldPickerObj.y2LineColor,
          data: response[1],
          dashStyle: fieldPickerObj.dashStyleY2
        }];
      } else {
        options.series = [{
          type: fieldPickerObj.chartypeY1,
          name: fieldPickerObj.y1Axis,
          color: fieldPickerObj.y1LineColor,
          data: response[0],
          dashStyle: fieldPickerObj.dashStyleY1
        }];
      }

      var chart = new Highcharts.Chart(options);
      chart.options.chart.animation = true;
      chart.redraw();

      if (hasDate) {
        // Convert timestamps to dates
        timestampToDate(response[0]);
        timestampToDate(response[1]);
      }

      initTableY1(response[0], chart); // table y1 data
      initTableY2(response[1], chart); // table y2 data

    }
  });
}

function drill(uid, filename, options, fieldPickerObj, selectedDate) {

  // User clicked on point to zoom in graph
  drilled = true;

  // Set selectedDate to fieldPickerObj
  fieldPickerObj.selectedDate = selectedDate;

  // Use datetime so the field datetize is fetched from the db because i want fore the x axis full datetime timestamp or else if I have only time i get wrong date and the graph shows current date today
  fieldPickerObj.xAxis = 'datetime';

  $.ajax({
    type: "POST",
    url: "./pages/statistics/runQuery.php", // this.x == date timestamp
    data: {
      action: 'executeDrill',
      first: uid,
      second: filename,
      third: JSON.stringify(fieldPickerObj)
    },
    dataType: "json",
    success: function (response) {
        // Pop xAxis back to date so apply btn can work again
        fieldPickerObj.xAxis = 'date';

        options.title = {
          text: "Y1 " + fieldPickerObj.y1Axis + " Y2 " + fieldPickerObj.y2Axis + " by " + fieldPickerObj.xAxis
        };

        options.series = [{
          type: fieldPickerObj.chartypeY1,
          name: fieldPickerObj.y1Axis,
          color: fieldPickerObj.y1LineColor,
          data: response[0],
          dashStyle: fieldPickerObj.dashStyleY1,
        }, {
          type: fieldPickerObj.chartypeY2,
          name: fieldPickerObj.y2Axis,
          color: fieldPickerObj.y2LineColor,
          data: response[1],
          dashStyle: fieldPickerObj.dashStyleY2,
        }];

        var chart = new Highcharts.Chart(options);
        chart.options.chart.animation = false;

        chart.redraw();

				timestampToTime(response[0]);
				timestampToTime(response[1]);
        // Set new data to tables
				initTableY1(response[0], chart); // table y1 data
	      initTableY2(response[1], chart); // table y2 data

        // Change apply btn name to back
        $('#MainApplyBtn').html('Back/Apply');
        // Change padding for the text to fit
        $('#MainApplyBtn').css({
          "padding-right": "103px"
        });
        chart.hideLoading();
      } // success
  }); // Ajax
}

function timestampToTime(response){
	for (var i = response.length - 1; i >= 0; i--) {
  	for (var j = response[i].length - 1; j > 0; j--) {
			response[i][0] = (new Date(response[i][0])).toISOString().slice(11, 19);
		}
	}

}

function formatTitle(obj) {
  if (obj.xAxis) {
    str = 'x:' + obj.xAxis;
  }
  if (obj.y1Axis) {
    str += ' y1:' + obj.y1Axis;
  }
  if (obj.y2Axis) {
    str += ' y2:' + obj.y2Axis;
  }

  return str;
}

// Convert timestamp to date
function timestampToDate(timestamp) {
  for (var i = timestamp.length - 1; i >= 0; i--) {
    for (var j = timestamp[i].length - 1; j >= 0; j--) {
      timestamp[i][0] = (new Date(timestamp[i][0])).toISOString().slice(0, 10);
    }
  }
}

// Remove json values that are null
function clean(obj) {
  var propNames = Object.getOwnPropertyNames(obj);
  for (var i = 0; i < propNames.length; i++) {
    var propName = propNames[i];
    if (obj[propName] === null || obj[propName] === undefined) {
      delete obj[propName];
    }
  }
}

// Datatables init
function initTableY1(tableY1Data, chart) {
  var y1Table = $('#data-tableY1').DataTable();

  y1Table.destroy();

  y1Table = $('#data-tableY1').DataTable({
    paging: true,
    dom: 'Bfrtip',
    buttons: [
      'csv', 'excel'
    ],
    data: tableY1Data
  });

  // Check if chart has data
  if (chart.series.length > 0) {
    $('#data-tableY1').show(500);
  } else {
    $('#data-tableY1').hide(500);
  }
}

function initTableY2(tableY2Data, chart) {
  var y2Table = $('#data-tableY2').DataTable();

  y2Table.destroy();

  y2Table = $('#data-tableY2').DataTable({
    paging: true,
    data: tableY2Data
  });

  // Check if chart has data
  if (chart.series.length > 0) {
    $('#data-tableY2').show(500);
  } else {
    $('#data-tableY2').hide(500);
  }
}

//============================
//====Query obj functions
//============================
// Jquery query builder init
var sql_import_export;

var rules_y1 = {
  condition: 'AND',
  rules: []
};

$('#builder-y1').queryBuilder({
  plugins: [
    'bt-tooltip-errors',
    'not-group',

  ],
  allow_empty: true,

  filters: [{
    id: 'acc.host',
    label: 'Host',
    type: 'string',
  }, {
    id: 'timezone',
    label: 'Timezone',
    type: 'string',
    operators: ['equal', 'not_equal', 'in', 'not_in', 'begins_with', 'not_begins_with', 'contains', 'not_contains', 'ends_with', 'not_ends_with']
  }, {
    id: 'acc.method',
    label: 'Method',
    type: 'string',
    input: 'select',
    values: {
      GET: 'GET',
      POST: 'POST',
      HEAD: 'HEAD',
      PUT: 'PUT',
      DELETE: 'DELETE',
      PROPFIND: 'PROPFIND',
      OPTIONS: 'OPTIONS',
    },
    operators: ['equal', 'not_equal', 'less', 'less_or_equal', 'greater', 'greater_or_equal', 'between', 'not_between']
  }, {
    id: 'acc.request',
    label: 'Request',
    type: 'string',
    operators: ['equal', 'not_equal', 'in', 'not_in', 'begins_with', 'not_begins_with', 'contains', 'not_contains', 'ends_with', 'not_ends_with']
  }, {
    id: 'acc.resource',
    label: 'Resource',
    type: 'string',
    operators: ['equal', 'not_equal', 'in', 'not_in', 'begins_with', 'not_begins_with', 'contains', 'not_contains', 'ends_with', 'not_ends_with']
  }, {
    id: 'acc.status_code',
    label: 'Status code',
    type: 'string',

    operators: ['equal', 'not_equal', 'contains', 'not_contains']
  }, {
    id: 'acc.obj_size',
    label: 'Object size',
    type: 'integer',
    validation: {
      min: 0,
      step: 100
    },
    operators: ['equal', 'not_equal', 'in', 'not_in', 'less', 'less_or_equal', 'greater', 'greater_or_equal', 'between', 'not_between']
  }, {
    id: 'acc.country',
    label: 'Country',
    type: 'string',
    operators: ['equal', 'not_equal']
  }, ],
  rules: rules_y1
});

var rules_y2 = {
  condition: 'AND',
  rules: []
};

$('#builder-y2').queryBuilder({
  plugins: [
    'bt-tooltip-errors',
    'not-group'
  ],

  allow_empty: true,

  filters: [{
    id: 'acc.host',
    label: 'Host',
    type: 'string',
  }, {
    id: 'acc.timezone',
    label: 'Timezone',
    type: 'string',
    operators: ['equal', 'not_equal', 'in', 'not_in', 'begins_with', 'not_begins_with', 'contains', 'not_contains', 'ends_with', 'not_ends_with']
  }, {
    id: 'acc.method',
    label: 'Method',
    type: 'string',
    input: 'select',
    values: {
      GET: 'GET',
      POST: 'POST',
      HEAD: 'HEAD',
      PUT: 'PUT',
      DELETE: 'DELETE',
      PROPFIND: 'PROPFIND',
      OPTIONS: 'OPTIONS',
    },
    operators: ['equal', 'not_equal', 'less', 'less_or_equal', 'greater', 'greater_or_equal', 'between', 'not_between']
  }, {
    id: 'acc.request',
    label: 'Request',
    type: 'string',
    operators: ['equal', 'not_equal', 'in', 'not_in', 'begins_with', 'not_begins_with', 'contains', 'not_contains', 'ends_with', 'not_ends_with']
  }, {
    id: 'acc.resource',
    label: 'Resource',
    type: 'string',
    operators: ['equal', 'not_equal', 'in', 'not_in', 'begins_with', 'not_begins_with', 'contains', 'not_contains', 'ends_with', 'not_ends_with']
  }, {
    id: 'acc.status_code',
    label: 'Status code',
    type: 'string',
    operators: ['equal', 'not_equal', 'contains', 'not_contains']
  }, {
    id: 'acc.obj_size',
    label: 'Object size',
    type: 'integer',
    validation: {
      min: 0,
      step: 100
    },
    operators: ['equal', 'not_equal', 'in', 'not_in', 'less', 'less_or_equal', 'greater', 'greater_or_equal', 'between', 'not_between']
  }, {
    id: 'acc.country',
    label: 'Country',
    type: 'string',
    operators: ['equal', 'not_equal']
  }, ],
  rules: rules_y2
});


function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1);
}

// left is the left field of range picker
function setDateTimeBox() {
  var left = $('.left > .daterangepicker_input > .input-mini').val().split(' ');
  var right = $('.right > .daterangepicker_input > .input-mini').val().split(' ');
  $('#termXdateRange').val(left[0] + " " + left[1] + " - " + right[0] + " " + right[1]);
}

//Menu Toggle Script
$("#menu-toggle").click(function (e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
  setTimeout(reflowChart, 500);
});

function reflowChart() {
  $('#dynamicChart').highcharts().reflow();
}
</script>
