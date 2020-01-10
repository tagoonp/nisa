<?php
// exec("test_r.R");
// exec("Rscript test_r.R $N");

echo "
";
echo "Number values to generate:
";
echo "Submit";
echo ""
;

if(isset($_GET['N']))
{
  $N = $_GET['N'];

  // execute R script from shell
  // this will save a plot at temp.png to the filesystem
  exec("Rscript test_r.R $N");

  // return image tag
  $nocache = rand();
  echo("");
}

?>
