<?php  
      //export.php  
 if(isset($_POST["export"]))  
 {  
     $connect = mysqli_connect("ChachePricesUsr.db.5173196.b61.hostedresource.net"
                              , "ChachePricesUsr"
                              , "Facundillo@2020");
                              
      header('Content-Type: text/csv; charset=utf-8');  
      header('Content-Disposition: attachment; filename=data.csv');  
      $output = fopen("php://output", "w");  
      fputcsv($output, array('ItemAsin', 'ItemName', 'Category', 'ItemPrice', 'ItemUrl', 'imageurl', 'discountPrice', 'ultimaFecha'));  
      
      $query ="SELECT ChachePricesUsr.items.ItemAsin, ChachePricesUsr.items.itemName, ChachePricesUsr.items.Category, ChachePricesUsr.items.ItemPrice, 
               ChachePricesUsr.items.ItemUrl, ChachePricesUsr.cacheprices.imageurl, discountPrice, ultimaFecha, 
               'External' as Tipo, 'Comprar en Amazon' as TextoBoton from ChachePricesUsr.cacheprices 
               inner join  (SELECT idItems,  max(PriceDate) as ultimaFecha FROM ChachePricesUsr.cacheprices group by idItems order by idItems,
               pricedate) ultimoprecio on ChachePricesUsr.cacheprices.idItems = ChachePricesUsr.ultimoprecio.idItems
               and ChachePricesUsr.cacheprices.priceDate = ChachePricesUsr.ultimoprecio.ultimaFecha inner join ChachePricesUsr.items on
               ChachePricesUsr.cacheprices.idItems = ChachePricesUsr.items.idItems where ultimaFecha >= DATE_ADD(CURDATE(), INTERVAL -3 DAY) order by priceDate desc ;";  
      
      $result = mysqli_query($connect, $query);  
      while($row = mysqli_fetch_assoc($result))  
      {  
           fputcsv($output, $row);  
      }  
      fclose($output);  
 }  
 ?>  