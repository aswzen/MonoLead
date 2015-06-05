
        <link rel="stylesheet" href="<?php echo STATIC_DIR; ?>css/w2ui.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo STATIC_DIR; ?>css/style.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo STATIC_DIR; ?>css/icon.css" type="text/css" media="screen" />
     	<script type="text/javascript" src="<?php echo STATIC_DIR; ?>js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_DIR; ?>js/w2ui.js"></script>

		<div id="project_grid" style="width: 600px; height: 540px;"></div>
		<script type="text/javascript">
			$(function () {
    $('#project_grid').w2grid({ 
        name: 'project_grid', 
        searches: [                
            { field: 'fname', caption: 'First Name', type: 'text' },
            { field: 'lname', caption: 'Last Name', type: 'text' },
            { field: 'email', caption: 'Email', type: 'text' },
        ],
        sortData: [ { field: 'lname', direction: 'asc' } ],
        columns: [                
            { field: 'recid', caption: 'ID', size: '50px', sortable: true },
            { field: 'fname', caption: 'First Name', size: '30%', sortable: true },
            { field: 'lname', caption: 'Last Name', size: '30%', sortable: true },
            { field: 'email', caption: 'Email', size: '40%' },
            { field: 'sdate', caption: 'Start Date', size: '120px' },
        ],
        records: [
            { recid: 1, fname: 'John', lname: 'doe', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 2, fname: 'Stuart', lname: 'Motzart', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 3, fname: 'Jin', lname: 'Franson', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 4, fname: 'Susan', lname: 'Ottie', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 5, fname: 'Kelly', lname: 'Silver', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 6, fname: 'Francis', lname: 'Gatos', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 7, fname: 'Mark', lname: 'Welldo', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 8, fname: 'Thomas', lname: 'Bahh', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 9, fname: 'Sergei', lname: 'Rachmaninov', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 20, fname: 'Jill', lname: 'Doe', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 21, fname: 'Frank', lname: 'Motzart', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 22, fname: 'Peter', lname: 'Franson', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 23, fname: 'Andrew', lname: 'Ottie', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 24, fname: 'Manny', lname: 'Silver', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 25, fname: 'Ben', lname: 'Gatos', email: 'jdoe@gmail.com', sdate: '4/3/2012' }
        ]
    });    

		});
		</script>