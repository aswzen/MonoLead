<head>
	<title>MonoLead - Setup</title>
</head>
<style type="text/css">
	body{
		font: 14px Tahoma;
	}
	.header,.footer{
		width:600px; 
		margin:0 auto;
		border:1px solid gray;
		padding:10px;
		background-color: #EAEAEA;
		height: 25px;
	}
	.content{
		width:600px; 
		margin:0 auto;
		border:1px solid gray;
		padding:10px;
		background-color: #EAEAEA;
		height: 300px;
	}
	.info{
		font-size: 10px;
	}
</style>
<body>
	<form>
    <div class="header">
        MonoLead Setup
    </div>
    <div class="content">
        <table style="width:100%">
        	<tr>
        		<th colspan="3">General</th>
        	</tr>
        	<tr>
        		<td style="width:170px">Base Url</td>
        		<td>:</td>
        		<td><input type="text" name="" style="width:200px"/> <span class="info">*leave it blank if you don't know</span></td>
        	</tr>
        	<tr>
        		<td>Site Name</td>
        		<td>:</td>
        		<td><input type="text" name="" style="width:250px" value="MonoLead - Project Management System"/> <span class="info">*will appear on every top page</span></td>
        	</tr>
        	<tr>
        		<td >Site Footer</td>
        		<td>:</td>
        		<td><input type="text" name="" style="width:250px" value="(c) MonoLead 2015"/> <span class="info">*will appear on every bottom page</span></td>
        	</tr>
        	<tr>
        		<td >Date Format</td>
        		<td>:</td>
        		<td><input type="text" name="" style="width:100px" value="d F Y H:i"/> <span class="info">*date time format (based on PHP)</span></td>
        	</tr>
        	<tr>
        		<th colspan="3">Database</th>
        	</tr>
        	<tr>
        		<td>Database Address/Host</td>
        		<td>:</td>
        		<td><input type="text" name="" style="width:250px" value="localhost"/> <span class="info">*your database address</span></td>
        	</tr>
        	<tr>
        		<td>Database Name</td>
        		<td>:</td>
        		<td><input type="text" name="" style="width:250px" value="monolead"/> <span class="info">*your database name</span></td>
        	</tr>
        	<tr>
        		<td>Database Password</td>
        		<td>:</td>
        		<td><input type="password" name="" style="width:250px" value=""/> <span class="info">*your database password</span></td>
        	</tr>
        	<tr>
        		<th colspan="3">Additional</th>
        	</tr>
        	<tr>
        		<td>Install sample data?</td>
        		<td>:</td>
        		<td><input type="checkbox" name="" /> <span class="info">*sample data to make sure the app works</span></td>
        	</tr>
        </table>
    </div>
    <div class="footer">
        <input type="submit" value="Submit Data" style="float:right">
    </div>
	</form>
</body>