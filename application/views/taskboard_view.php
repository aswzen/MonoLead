
<?php include('header.php'); ?>
    
    <div id="content">
        <div id="layout_taskboard" style="height: 100%; width: 100%;"></div>   
    </div>

<?php include('footer.php'); ?>

<script>
$(function () {
    $.ajax({
        url: '<?php echo BASE_URL; ?>taskboard/showall',
        type: 'POST',
        data:{
            type:'ALL'
        },
        }).success(function(data){
        w2ui['layout_taskboard'].content('main', data);
    });

    $('#layout_taskboard').w2layout({
        name: 'layout_taskboard',
        panels: [
            { type: 'left', size: 230, resizable: true, style: 'background-color: #F5F6F7;border-right:1px solid #C0C0C0;', content: 'left' },
            { type: 'main', style: 'background-color: #F5F6F7; padding: 5px;' }
        ]
    });

    w2ui['layout_taskboard'].content('left', $().w2sidebar({
        name: 'task_sidebar',
        img: null,
        nodes: <?php echo $_PROJECT_DATA; ?>,
        onClick: function (event) {
            loadTaskboard(event);
        }
    }));

    function loadTaskboard(event){
        if(event.node['type'] == 'task'){
            $().w2destroy('layout_preview_task');
        }

        $.ajax({
            url: '<?php echo BASE_URL; ?>taskboard'+event.node['link'],
            type: 'POST',
            dataType: "HTML",
            }).success(function(data){
            w2ui['layout_taskboard'].content('main', data);
        });
    }
});
</script>