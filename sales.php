<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Wheel Group - Sales Register</title>
    <?php include('./includes/headerTags.php');?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include('./includes/topNavBar.php');?>
  <?php 
  $page='';
  include('./includes/sidebar.php');?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sales Register</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sales</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="col-md-12 col-sm-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Sales History</h3>
            </div>
          <div class="card-body">
            <div>
              <table class="table table-striped table-sm">
                <thead>
                  <tr class="d-flex">
                    <th class="col-1" scope="col">Date</th>
                    <th class="col-1 text-center" scope="col">Inv #</th>
                    <th class="col-5" scope="col">Customer</th>
                    <th class="col-1 text-right" scope="col">Cash Sale</th>
                    <th class="col-1 text-right" scope="col">Cheque Sale</th>
                    <th class="col-1 text-right" scope="col">Credit Sale</th>
                    <th class="col-1 text-right" scope="col">Inv. Total</th>
                    <th class="col-1 text-right" scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                      <?php 
                      $results_per_page = 15;
                      $page = 1;
                      if (isset ($_GET['page']) ) {  
                        $page = $_GET['page'];   
                      } 
                      $page_first_result = ($page-1) * $results_per_page;  

                      $sql = "SELECT * FROM sales"; 
                      $result1 = mysqli_query($con, $sql);
                      $number_of_result = mysqli_num_rows($result1);  
                      
                      $number_of_page = ceil ($number_of_result / $results_per_page);  
                      
                      $sql = "SELECT sales.sales_id, sales.sale_date, sales.inv_no, sales.cash_sale, sales.chq_sale, sales.credit_sale, customers.customer_name, sale_by.sale_by_name
                      FROM sales 
                      INNER JOIN customers ON sales.customer_id = customers.customer_id 
                      INNER JOIN sale_by ON sales.sale_by = sale_by.sale_by_id 
                      ORDER BY sales.sale_date DESC
                      LIMIT " . $page_first_result . ',' . $results_per_page;

                      $result1 = mysqli_query($con, $sql);

                      while($row1 = mysqli_fetch_array($result1)){?>
                        <tr class="d-flex">
                          <td class="col col-1"><?=$row1["sale_date"]?></td>
                          <td class="col col-1 text-center"><?=$row1["inv_no"]?></td>
                          <td class="col col-5"><?=$row1["customer_name"]?> <span class="badge bg-warning"><?=$row1["sale_by_name"]?></span></td>
                          <td class="text-right col col-1"><?=number_format($row1["cash_sale"],2, '.', ',')?></td>
                          <td class="text-right col col-1"><?=number_format($row1["chq_sale"],2, '.', ',')?><a href="cheques.php?sale_id=<?=$row1["sales_id"]?>" class=" btn btn-sm p-0 <?php if($row1["chq_sale"]=='0.00'){echo 'invisible';}?>"><i class="fas fa-info-circle ml-1 text-success"></i></a></td>
                          <td class="text-right col col-1"><?=number_format($row1["credit_sale"],2, '.', ',')?><a href="debtors.php?sale_id=<?=$row1["sales_id"]?>" class=" btn btn-sm p-0 <?php if($row1["credit_sale"]=='0.00'){echo 'invisible';}?>"><i class="fas fa-info-circle ml-1 text-warning"></i></a></td>
                          <td class="text-right col col-1"><?=number_format($row1["cash_sale"]+$row1["chq_sale"]+$row1["credit_sale"],2, '.', ',')?></td>
                          <td class="text-center col col-1"><a href="new_sale.php?sale_id=<?=$row1["sales_id"]?>"><i class="far fa-edit text-success"></i></a></td>
                        </tr>
                      <?php } ?>

                  
                  
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <nav aria-label="...">
              <ul class="pagination justify-content-center">
                <li class="page-item <?php if($page==1){echo "disabled";}?>">
                  <a class="page-link" href="?page=<?=$page-1?>" tabindex="-1">Previous</a>
                </li>
                <?php 
                for($i=1; $i<=$number_of_page; $i++){ ?>
                  <li class="page-item <?php if($i==$page){echo "active";}?>">
                    <a class="page-link" href="?page=<?=$i?>"><?=$i?></a>
                  </li>
                <?php } ?>
                
                <li class="page-item  <?php if($page>=$number_of_page){echo "disabled";}?>">
                  <a class="page-link" href="?page=<?=$page+1?>">Next</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include("./includes/footer.php"); ?>
</div>
<!-- ./wrapper -->

<?php include("./includes/footerTags.php"); ?>
</body>
</html>