<script id="template-upload" type="text/x-tmpl">

{% for (var i=0, file; file=o.files[i]; i++) { %}

	<div class="filemanager-item">

		<span class="filemanager-item-progress template-upload">
	        <div class="progress active">
	            <div class="progress-bar progress-bar-success" style="width:0%;"></div>
	        </div>
	    </span>

	</div>

{% } %}

</script>