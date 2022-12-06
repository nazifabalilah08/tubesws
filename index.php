<?php
	require_once realpath(__DIR__)."/vendor/autoload.php";
    require_once __DIR__."/html_tag_helpers.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <?php include 'source.php'; ?>
    <title>Wibzz</title>
</head>

<body>
<?php include "navbar.php";?>



 <div class="container mt-5">
	<h3 class="text-center">Hai wibzz, silahkan cari manga yang kamu mau</h3>
	<div class="row justify-content-center">

	

	  <div class="row">
	  	<?php

	  		\EasyRdf\RdfNamespace::set('geo', 'http://www.w3.org/2003/01/geo/wgs84_pos#');
		    \EasyRdf\RdfNamespace::set('foaf', 'http://xmlns.com/foaf/0.1/');
		    \EasyRdf\RdfNamespace::set('dbp', 'http://dbpedia.org/property/');
		    \EasyRdf\RdfNamespace::set('dbo', 'http://dbpedia.org/ontology/');
		    \EasyRdf\RdfNamespace::set('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
		    \EasyRdf\RdfNamespace::set('rdfs', 'http://www.w3.org/2000/01/rdf-schema#');
		    \EasyRdf\RdfNamespace::set('owl', 'http://www.w3.org/2002/07/owl#');
		    \EasyRdf\RdfNamespace::set('comic', 'http://example.org/schema/comic/');
		    \EasyRdf\RdfNamespace::setDefault('og');

		    $jena_endpoint = 'http://localhost:3030/manga/query';
		    $sparql_jena = new \EasyRdf\Sparql\Client($jena_endpoint);

		    $sparql_query = '
		    	SELECT ?judul ?tahun ?link ?f ?no
				WHERE {
				  ?f a comic:manga;
				     rdfs:label ?judul;
					 comic:year ?tahun;
					 comic:nomor ?no;
					 foaf:homepage ?link.
				}
				ORDER BY rand() LIMIT 12';

			$result = $sparql_jena->query($sparql_query);

			foreach ($result as $row) {

			$myanimelist_link = \EasyRdf\Graph::newAndLoad($row->link);
			$src_poster = $myanimelist_link->image;

	  	?>
		<div class="card movie_card">
		  <img src="<?= $src_poster ?>" alt="...">
		  <div class="card-body">
		    <h5 class="card-title"><?= $row->judul ?></h5>
		   		<span class="movie_info"><?= $row->tahun ?></span>
		   		<br><a href="detail.php?q=<?= $row->no ?>" class="btn btn-sm btn-danger float-right">Details</a><br>
		  </div>
		</div>
		<?php } ?>
	  </div>	

	</div>

 </div>
</body>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<?php include "footer.php";?>

	<script>
		$(function () {
  		$('[data-toggle="tooltip"]').tooltip()
	})
	</script>

</body>
</html>