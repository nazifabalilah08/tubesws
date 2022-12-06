<?php
	require_once realpath(__DIR__)."/vendor/autoload.php";
    require_once __DIR__."/html_tag_helpers.php";

    $id = $_GET['q'];
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
<?php
	
//	\EasyRdf\RdfNamespace::set('geo', 'http://www.w3.org/2003/01/geo/wgs84_pos#');
	\EasyRdf\RdfNamespace::set('foaf', 'http://xmlns.com/foaf/0.1/');
//	\EasyRdf\RdfNamespace::set('dbp', 'http://dbpedia.org/property/');
	\EasyRdf\RdfNamespace::set('dbo', 'http://dbpedia.org/ontology/');
	\EasyRdf\RdfNamespace::set('rdf', 'http://www.w3.org/1999/02/22-rdf-syntax-ns#');
	\EasyRdf\RdfNamespace::set('rdfs', 'http://www.w3.org/2000/01/rdf-schema#');
//	\EasyRdf\RdfNamespace::set('owl', 'http://www.w3.org/2002/07/owl#');
	\EasyRdf\RdfNamespace::set('comic', 'http://example.org/schema/comic/');
	\EasyRdf\RdfNamespace::setDefault('og');

	$jena_endpoint = 'http://localhost:3030/manga/query';
	$sparql_jena = new \EasyRdf\Sparql\Client($jena_endpoint);

	$sparql_query = '
		SELECT DISTINCT ?judul ?tahun ?link ?dbpedia ?trailer
			WHERE {
		?dbpedia a comic:manga;
		         comic:nomor ?no;
				 rdfs:label ?judul;
				 comic:year ?tahun;
		     	 comic:preview ?trailer;
				 foaf:homepage ?link.
		    FILTER (?no = "'.$id.'"). 
		}';

	$result = $sparql_jena->query($sparql_query);

?>

	<div class="container">
	<br>
	
		<div class="card">
			<?php
				foreach ($result as $row) {

					$myanimelist_link = \EasyRdf\Graph::newAndLoad($row->link);
					$src_poster = $myanimelist_link->image;

					$des = $myanimelist_link->description;
			?>
			<div class="row">
				<aside style="padding-left: 20px; padding-top: 5px;" class="col-sm-3">
					<article> 
						<div>
						  <img style="width: 300px" src="<?= $src_poster ?>">
						</div> <!-- slider-product.// -->
					</article> <!-- gallery-wrap .end// -->
				</aside>
				<aside class="col-sm-9">
					<article class="card-body p-5">
						<h3 class="title mb-3"><?= $row->judul ?></h3>
						<h5 class="title mb-3"><?= $row->tahun ?></h5>

						<dl class="item-property">
						  <dd>
						  	<p><?= $des ?></p>
						  	<p>- <a href="<?= $myanimelist_link->url ?>"><?= $myanimelist_link->site_name ?></a></p>
						   </dd>
						</dl>
						<br>
						<dl class="param param-feature">
						  <div>
						  	<iframe width="560" height="315" src="<?= $row->trailer ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
						  </div>
						</dl>  <!-- item-property-hor .// -->
						<dl class="param param-feature">
						  <?php
						  	$dbpedia_endpoint = 'https://dbpedia.org/sparql';
							$sparql_dbpedia = new \EasyRdf\Sparql\Client($dbpedia_endpoint);

							$sparql_dbpedia_query = '
								SELECT DISTINCT * WHERE {
									<'.$row->dbpedia.'> dbo:author ?r_d.
              									?r_d 	foaf:name ?author
              					}';

							$result_bg = $sparql_dbpedia->query($sparql_dbpedia_query);

						?>
						<dl class="param param-feature">
							<dt>Author</dt>
							<dd>
								<?php
									foreach ($result_bg as $strdr) {
										echo "- <a href='author.php?q=".$strdr->r_d."'>".$strdr->author."</a> <br>";
									}
								?>
							</dd>
						</dl>

						<hr>

						<a href="javascript:history.back()" class="btn btn-md btn-danger"> Back </a>
					</article> <!-- card-body.// -->
				</aside> <!-- col.// -->
			</div> <!-- row.// -->
			<?php } ?>
		</div> <!-- card.// -->


	</div>
<!--container.//-->

<?php include "footer.php";?>
</body>
</html>