<script id="template-download" type="text/x-tmpl">

	{% for (var i=0, file; file=o.files[i]; i++) { %}

		<a href="{%= file.updateUrl %}" data-pjax="0" class="filemanager-item" data-id="{%= file.id %}" data-image="{%= file.thumbnailUrl %}" data-isImage="{%= file.isImage %}">

	        {% if (file.thumbnailUrl && file.isImage) { %}
	            <img src="{%=file.thumbnailUrl%}">
	        {% } else { %}

	            <i class="filemanager-item-icon glyphicon glyphicon-file"></i>
	            <span class="filemanager-item-name">{%= file.name %}</span>

	        {% } %}

			<button type="button" class="filemanager-item-check">
				<i class="glyphicon glyphicon-ok"></i>
			</button>

	    </a>

	{% } %}

</script>
