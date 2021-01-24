<script src='/ckeditor/ckeditor.js'></script>
<textarea name="comment" rows="15" style="width:100%;height:250;"></textarea>
<script type="text/javascript">
    CKEDITOR.replace('comment',
    {
    startupFocus : false,  // 자동 focus 사용할때는  true
    skin: 'moonocolor',
    customConfig : '/ckeditor/config.js', //커스텀설정js파일위치
    //filebrowserUploadUrl: '/ckeditor/upload.php?type=Files',
    filebrowserImageUploadUrl: '/ckeditor/upload.php?type=Images',
    //filebrowserFlashUploadUrl: '/ckeditor/upload.php?type=Flash'
    }
);
</script>
