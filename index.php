<?php  
 $connect = mysqli_connect("ChachePricesUsr.db.5173196.b61.hostedresource.net"
                              , "ChachePricesUsr"
                              , "Facundillo@2020");



if (mysqli_connect_errno()) {
     printf("Connect failed: %s\n", mysqli_connect_error());
     exit();
}

 $query ="SELECT ChachePricesUsr.items.ItemAsin, ChachePricesUsr.items.itemName, ChachePricesUsr.items.Category, ChachePricesUsr.items.ItemPrice, 
          ChachePricesUsr.items.ItemUrl, ChachePricesUsr.cacheprices.imageurl, discountPrice, ultimaFecha, 
          'External' as Tipo, 'Comprar en Amazon' as TextoBoton from ChachePricesUsr.cacheprices 
          inner join  (SELECT idItems,  max(PriceDate) as ultimaFecha FROM ChachePricesUsr.cacheprices group by idItems order by idItems,
          pricedate) ultimoprecio on ChachePricesUsr.cacheprices.idItems = ChachePricesUsr.ultimoprecio.idItems
          and ChachePricesUsr.cacheprices.priceDate = ChachePricesUsr.ultimoprecio.ultimaFecha inner join ChachePricesUsr.items on
          ChachePricesUsr.cacheprices.idItems = ChachePricesUsr.items.idItems where ultimaFecha >= DATE_ADD(CURDATE(), INTERVAL -3 DAY) order by priceDate desc ;";  


 $result = mysqli_query($connect, $query);  

 
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>CSV EXPORT</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>  
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:900px;">  
                <h2 align="center">Export Mysql Products Data to CSV File</h2> 
                
                <br />  
                <form method="post" action="export.php" >  
                     <input type="submit" name="export" value="CSV Export" class="btn btn-success" />  
                </form>  
                <br />  
           </div>  
      </body>  
 </html>  
