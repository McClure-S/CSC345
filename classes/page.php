<?php
/*
page.php
This is a class used to build a page with a bootstrap 3 template.

Created: 10/31/2018
Author: Larry Elliott
Helpful Links:
    https://www.w3schools.com/bootstrap/bootstrap_theme_company.asp
    https://www.w3schools.com/bootstrap/bootstrap_ref_comp_glyphs.asp
    https://getbootstrap.com/docs/3.3/components/
*/

class Page {
	private $title;
	private $subtitle;
	private $navigation;
	private $content;
	
	function __construct ($title = "Page Title", $navigation = array()) {
		$this->title = $title;
		$this->navigation = $navigation;
		$this->subtitle = "";
		$this->content = "";
	}
	
	function setTitle ($title) {
		$this->title = $title;
	}
	
	function setSubtitle ($subtitle) {
		$this->subtitle = $subtitle;
	}
	
	function setNavigation ($navigation) {
		$this->navigation = $navigation;
	}
	
	function addNavigationItem ($title, $link) {
		$this->navigation[$title] = $link;
	}
	
	function addContent ($new_content) {
		$this->content .= $new_content;
	}
	
	function containerStart ($id = "", $class="") {
		$this->content .= '<div id="'.$id.'" class="container-fluid '.$class.'">'."\n";
	}
	
	function containerEnd () {
		$this->content .= '</div>'."\n";
	}
	
	function renderPage ($session = false) {
		$this->renderHeader();
		
		if ($session) {
			$messages = $session->getMessages();
			if (strlen($messages) > 1)
				echo '<div id="messages" class="container-fluid">'."\n".$messages."</div>\n";
		}
		
		echo $this->content;
		
		$this->renderFooter();
	}
	
	function startFieldset ($fieldset_title = "") {
		$this->addContent("<div class=\"fieldset\">\n");
		if (!empty($fieldset_title))
			$this->addContent("<h2>".$fieldset_title."</h2>\n");
	}

	function endFieldset () {
		$this->addContent("</div><!--end .fieldset-->\n");
	}
	
	function renderNavigation () {
		if (count($this->navigation) == 0)
			return;
		
		?>
		<nav class="navbar navbar-default navbar-fixed-top">
		  <div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                        
			  </button>
			  <a class="navbar-brand" href="/~easlick1km"><img src="imgs/logo.png"/></a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
			  <ul class="nav navbar-nav navbar-right">
			  
		
		<?php
		foreach ($this->navigation as $title => $link) {
			echo '<li><a href="'.$link.'">'.$title.'</a></li>'."\n";
		}
		
		?>
			  </ul>
			</div>
		  </div>
		</nav>
		
		<?php
	
	}
	
	function renderHeader () {
		if (empty($this->title)) {
			if (!empty($this->subtitle)) {
				$this->title = $this->subtitle;
				$this->subtitle = "";
			} else
				$this->title = "WebApps";
		}
	
		$title_html = "<h1>".$this->title."</h1>\n";
		$page_title = $this->title;
		
		if (!empty($this->subtitle)) {
			$title_html = "<h1>".$this->title." <br/><small>".$this->subtitle."</small></h1>\n";
			$page_title = $this->subtitle." | ".$page_title;
		}
	
		header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		?><!DOCTYPE html>
			<html lang="en">
			<head>
			  <title><?php echo $page_title; ?></title>
			  <meta charset="utf-8">
			  <meta name="viewport" content="width=device-width, initial-scale=1">
			  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
			  <link href="//fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
			  <link href="//fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
			  <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
			  <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
			  <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css">
			  <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
			  <script src="//cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
			  <link href="style.php" rel="stylesheet" type="text/css">
			</head>
			<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

						<?php
						$this->renderNavigation();
						?>

			<div class="jumbotron text-center">
			  <?php echo $title_html; ?>
			</div>
		
			<?php
	}
	
	function renderFooter () {
			?>
			
			<footer class="container-fluid text-center">
			  <a href="#myPage" title="To Top">
				<span class="glyphicon glyphicon-chevron-up"></span>
			  </a>
			  <p>Bootstrap Theme Made By <a href="https://www.w3schools.com" title="Visit w3schools">www.w3schools.com</a></p>
			</footer>

			<script>
			$(document).ready(function(){

				$('.datatable')
					.addClass( 'nowrap' )
					.dataTable( {
						responsive: true,
						autoWidth: false,
						columnDefs: [
							{ targets: [-1, -3], className: 'dt-body-right' }
						]
					} );
	
				$('.file-input').change(function(event) {
					//alert( "Handler for .change() called by "+event.target.id);
					fileChanged(event.target.id);
				});
			})
			
			
			function fileChanged (id) {
				var file = document.getElementById(id).files[0];
				var size = document.getElementById(id).files[0].size;
				var filename = $('#'+id).val().split('\\').pop();
				var extension = filename.replace(/^.*\./, '');
				var upload_error = "";
				id = id.replace(/-file$/,'');
				$('#'+id+"-file-message").html("");
	
				if (size > 2097152) { // 2MB, TEXT up to 65,535 (64KB), MEDIUMTEXT 64MB
					upload_error += "File too big (over 2MB). ";
				}
	
				if ($.inArray(extension, ["pdf", "doc", "docx", "txt", "rtf", "jpeg", "jpg", "png", "gif"] ) == -1) {
					upload_error += "File type not supported (extensions supported: .pdf, .doc, .docx, .txt, .rtf, .jpg, .jpeg, .png, and .gif).";
				}
				
				if (upload_error != "") {
					$('#'+id+"-file-message").html('<div class="alert alert-danger" role="alert">'+upload_error+'</div>');
					$('#'+id+'-file').val('');
					$('#'+id+'Base64').val('');
					$('#'+id).val('');
					return;
				}
				
				
				$('#'+id).val(filename);
				
				var reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onload = function () {
					//console.log(reader.result);
					$('#'+id+'Base64').val(reader.result);
					//$('#'+id+'-file').val('');
					//$('#'+id+"-file-message").html('<div class="alert alert-success" role="alert">Your file looks good. ('+filename+')</div>');
				};
				reader.onerror = function (error) {
					console.log('Error: ', error);
					$('#'+id+'Base64').val("");
					$('#'+id).val('');
					$('#'+id+'-file').val('');
					$('#'+id+"-file-message").html('<div class="alert alert-danger" role="alert">There was an error with your file.</div>');
				};
			}
			
			</script>

			</body>
			</html>
		<?php
	}
	
}
