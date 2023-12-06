<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/classes/util.class.php";
    if(!Util::isGerente()){
        header('Location:/logIn.php?errormessage=Você%20não%20é%20gerente.');
    }

?>
<head>
  <script src="https://cdn.tiny.cloud/1/y3qkcwyb6cypt0eqf7lg9ff5yyr8mpvof08p1l27e1zn8569/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>



<form action="/admin/createnews.php" method="post" class="news">
	<h2>Registro de Notícias</h2>
	<div>
		<label for="title">Título: </label>
		<input type="text" name="title" id="title" required>
	</div>
	<div>
		<script>
			tinymce.init({
				selector: 'textarea',
				plugins: 'ai tinycomments mentions anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed permanentpen footnotes advtemplate advtable advcode editimage tableofcontents mergetags powerpaste tinymcespellchecker autocorrect a11ychecker typography inlinecss',
				toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
				menubar: 'false',
				tinycomments_mode: 'embedded',
				tinycomments_author: 'Author name',
				width: "640",
				content_style: 'img {max-width: 100%; height: auto;}',
				mergetags_list: [{
						value: 'First.Name',
						title: 'First Name'
					},
					{
						value: 'Email',
						title: 'Email'
					},
				],
				ai_request: (request, respondWith) => respondWith.string(() => Promise.reject(
					"See docs to implement AI Assistant")),
			});
		</script>
		<textarea name="content" id="content" cols="20" rows="5" required>

		</textarea>
	</div>
	<input type="submit" value="Registrar"></input>
</form>
