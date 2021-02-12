<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand text-primary" href="index.php">My Pharmacy</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">الموردين</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="suppliers.php">اضافة مورد</a>
          <a class="dropdown-item" href="index.php?page-title=sup-status"> تقرير بحالة كل الموردين</a>
          <a class="dropdown-item" href="#"> تقرير بحالة الاصناف التابعة للموردين</a>
          <a class="dropdown-item" href="#">تقرير بحالة مشتريات الموردين</a>
          <a class="dropdown-item" href="#">تقرير بحالة مردودات الموردين</a>
          <a class="dropdown-item" href="#">تقرير بحالة رصيد كل مورد</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">الأصناف</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="cats.php">اضافة صنف</a>
          <a class="dropdown-item" href="index.php?page-title=cats-status">تقرير بحالة الأصناف وأدويتها</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">الادوية</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="items.php">اضافة دواء</a>
          <a class="dropdown-item" href="index.php?page-title=items-status">تقرير بحالة الادوية وتصنيفاتها</a>
          <a class="dropdown-item" href="#">تقرير بحالة حد الطلب لكل دواء </a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">رصيد الصيدلية</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#">الرصيد الحالي للصيدلية</a>
          <a class="dropdown-item" href="#">الرصيد المدان علي الصيدلية</a>
          <a class="dropdown-item" href="#">الرصيد المدين علي الصيدلية</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">فواتير المبيعات</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="sales_bill.php">انشاء فاتورة مبيعات</a>
          <a class="dropdown-item" href="sales_return.php">انشاء فاتورة مردودات بيع</a>
          <a class="dropdown-item" href="#">تقرير بحالة المبيعات من الادوية</a>
          <a class="dropdown-item" href="#">تقرير بحالة مردودات المبيعات من الادوية</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">فواتير المشتريات</a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="purcheses.php">انشاء فاتورة مشتريات</a>
          <a class="dropdown-item" href="purcheses_return.php">انشاء فاتورة مردودات المشتريات</a>
          <a class="dropdown-item" href="#">تقرير بحالة المشتريات من الادوية</a>
          <a class="dropdown-item" href="#">تقرير بحالة مردودات المشتريات من الادوية</a>
        </div>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="بحث" name="search">
      <button class="btn btn-primary my-2 my-sm-0" type="submit">بحث</button>
    </form>
  </div>
</nav>