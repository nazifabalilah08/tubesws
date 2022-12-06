<?php
	require_once realpath(__DIR__)."/vendor/autoload.php";
    require_once __DIR__."/html_tag_helpers.php";

    $key = $_GET['keyword'];
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
	<h4 class="text-center">Hasil pencarian dari '<?= $key ?>'</h4>
	<br><br>
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
		    	SELECT DISTINCT ?judul ?tahun ?link ?f ?trlr ?no
					WHERE {
					{?f a comic:manga;
						rdfs:label ?judul;
						comic:year ?tahun;
						comic:nomor ?no;
				     	comic:preview ?trlr;
						foaf:homepage ?link.
				    FILTER REGEX (?judul, "'.$key.'", "i"). 
				  } UNION {
					?f a comic:manga;
						rdfs:label ?judul;
						comic:year ?tahun;
						comic:nomor ?no;
				     	comic:preview ?trlr;
						foaf:homepage ?link.
				    FILTER REGEX (?tahun, "'.$key.'", "i"). 
				  }
				}
				ORDER BY ASC (?judul)';

			$result = $sparql_jena->query($sparql_query);

			if($result->numRows() < 1){
				echo "<p>Waduh wibzz manga yang kamu cari ga ada nih</p>";
			}

			else{
			foreach ($result as $row) {

			$link_imdb = \EasyRdf\Graph::newAndLoad($row->link);
			$src_poster = $link_imdb->image;

	  	?>
		<div class="card movie_card">
		  <img src="<?= $src_poster ?>" alt="...">
		  <div class="card-body">
		    <h5 class="card-title"><?= $row->judul ?></h5>
		   		<span class="movie_info"><?= $row->tahun ?></span>
		   		<br><a href="detail.php?q=<?= $row->no ?>" class="btn btn-sm btn-danger float-right">Details</a><br>
		  </div>
		</div>
		<?php } 
			} ?>
	  </div>	

	</div>

 </div>
 <?php include 'footer.php'; ?>
</body>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

	<script>
		$(function () {
  		$('[data-toggle="tooltip"]').tooltip()
	})
	</script>
</body>
</html>