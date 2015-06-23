<?php include('header.php'); ?>
	
    <div id="content">
        <div id="layouts" style="width: 100%; height: 100%;"></div>
        <div id="config_head" style="display:none">
            <h1>Monolead</h1>
                Written in PHP 5.4, PIP PHP Framework, NotORM for PHP ORM Module, using jQuery, w2ui javascript 
                UI thanks to vitmalina (w2ui.com)<br><br>
                author : Agus Sigit Wisnubroto (aswzen@gmail.com)<br><br>
                Donation: <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=QTY3WBN669GP2&lc=ID&item_name=Agus%20Sigit%20W&item_number=aswzen&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted">Here</a>
        </div>
        <div id="config_site" style="display:none">
            <div id="form_site" style="width: 500px;height:auto"></div>
        </div>
        <div id="config_plugin" style="display:none"></div>  		
    </div>

<?php include('footer.php'); ?>


<script type="text/javascript">
$(function () {

    var pstyle = 'border: 1px solid #dfdfdf; padding: 5px;';
    $('#layouts').w2layout({
        name: 'layouts',
        panels: [
            { 
                type: 'top', 
                size: 150, 
                resizable: true, 
                style: pstyle, 
                content: $('#config_head').html()
            },
            { 
                type: 'left',
                size: 550,  
                style: pstyle + 'border-top: 0px;', 
                content: $('#config_site').html()
            },
            { 
                type: 'main', 
                resizable: true, 
                style: pstyle, 
                content: $('#config_plugin').html(), 
                title: 'Plugin' 
            }
        ]
    });

    $('#form_site').w2form({ 
        name    : 'form_site',
        header  : 'Site Configuration',
        url      : {
            save  : '<?php echo BASE_URL; ?>config/go_edit_config/'
        },
        fields : [
            { 
                field: 'maintenance_mode', 
                type: 'list', 
                required: true, 
                options: { 
                    items: [{"text":"Yes","id":"Yes"},{"text":"No","id":"No"}]
                },
                html: { 
                    caption: 'Maintenance Mode', 
                    text: ' *only admin allowed to view site',
                    attr: 'style="width: 100px"'
                } 
            },
            { 
                field: 'site_name', 
                type: 'text', 
                required: true, 
                html: { 
                    caption: 'Site Name', 
                    attr: 'style="width: 300px"'
                } 
            },
            { 
                field: 'additional_footer', 
                type: 'text', 
                html: { 
                    caption: 'Additional Footer', 
                    text: ' *footer text',
                    attr: 'style="width: 230px"'
                } 
            },
            { 
                field: 'datetime_format', 
                type: 'text', 
                html: { 
                    caption: 'Datetime Format', 
                    text: ' *PHP Format',
                    attr: 'style="width: 130px"'
                } 
            }
        ],
        record: <?php echo $_CONFIG_DATA; ?>,
        actions: {
            'Save': function (event) {
                this.save();
                showMessage('Configuration succesfully updated.','success') ;
            }
        }
    });
});
</script>
