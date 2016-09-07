<?php

class products_model extends inf_model {

    public function __construct() {
        $this->table_prefix = "9_";

        $this->session->set_userdata('inf_pos_prefix', '9');
    }

    public function addProduct($POST) {

        $name1 = 'product_image1';
        $name2 = 'product_image2';
        $name3 = 'product_image3';
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }

        extract($POST);
        /* $image_name1=$_FILES['product_image1']['name'];
          $image_name2=$_FILES['product_image2']['name'];
          $image_name3=$_FILES['product_image3']['name']; */
        //upload product image   
        $config['upload_path'] = './public_html/images/products/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '1000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';

        $this->load->library('upload', $config);
        if ($_FILES['product_image1']['error'] != 4) {
            if (!$this->upload->do_upload('product_image1')) {

                $error = array('error' => $this->upload->display_errors());
                $data['upload_data']['file_name'] = "";
            } else {

                $data = array('upload_data' => $this->upload->data());
                $file_name1 = $data['upload_data']['file_name'];
            }
        } else {
            $file_name1 = "noimage.png";
        }

        if ($_FILES['product_image2']['error'] != 4) {
            if (!$this->upload->do_upload('product_image2')) {

                $error = array('error' => $this->upload->display_errors());
                $data['upload_data']['file_name'] = "";
            } else {

                $data = array('upload_data' => $this->upload->data());
                $file_name2 = $data['upload_data']['file_name'];
            }
        } else {
            $file_name2 = "noimage.png";
        }

        if ($_FILES['product_image3']['error'] != 4) {
            if (!$this->upload->do_upload('product_image3')) {

                $error = array('error' => $this->upload->display_errors());
                $data['upload_data']['file_name'] = "";
            } else {

                $data = array('upload_data' => $this->upload->data());
                $file_name3 = $data['upload_data']['file_name'];
            }
        } else {
            $file_name3 = "noimage.png";
        }

        $res = $this->doProduct($POST, $file_name1, $file_name2, $file_name3, 'save');
        return $res;
    }

    public function addCategory($POST) {
        $name = 'category_image';
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        extract($POST);
        $image_name = $_FILES['category_image']['name'];
        if ($image_name == "") {
            $thumb_name = "imgs/categories/noimage.png";
            $res = $this->doCategory($POST, $thumb_name, 0, 'save');
        } else {
            $res = $this->checkImage($POST, $name, 'categories');
            if ($res['err'] == 0) {
                $filename = $res['filename'];
                $image_name = $res['image_name'];
                $extension = $res['extension'];
                $status = $this->create_thumb($filename, $extension, $image_name, 'category');
                if ($status) {
                    $thumb_name = "imgs/categories/" . $image_name;
                    //echo "$thumb_name";
                    $res = $this->doCategory($POST, $thumb_name, 1, 'save');
                }
            }
        }
        return $res;
    }

    public function addSubCategory($POST) {
        //$name = 'category_image';
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        extract($POST);
        /* $image_name=$_FILES['category_image']['name'];
          if($image_name=="")
          {
          $thumb_name = "imgs/categories/noimage.png";
          $res = $this->doCategory($POST, $thumb_name,0,'save');
          }
          else
          {
          $res = $this->checkImage($POST,$name,'categories');
          if($res['err']==0)
          {
          $filename = $res['filename'];
          $image_name = $res['image_name'];
          $extension = $res['extension'] ;
          $status = $this->create_thumb($filename, $extension, $image_name, 'category');
          if($status)
          {
          $thumb_name = "imgs/categories/".$image_name;
          echo "$thumb_name";
          $res = $this->doCategory($POST, $thumb_name,1, 'save');
          }
          }
          } */
        $res = $this->doSubCategory($POST, 'save');
        return $res;
    }

    function doProduct($POST, $img_name1, $img_name2, $img_name3, $action) {

        $res['err'] = 0;
        $product_name = addslashes($POST['product_name']);
        $brand = addslashes($POST['brand']);
        $product_category = addslashes($POST['product_category']);
        $product_subcategory = addslashes($POST['product_subcategory']);
        $product_count = $POST['product_count'];
        $price = addslashes($POST['price']);
        $tax = addslashes($POST['tax']);
        $featurs = addslashes($POST['featurs']);
        $description = addslashes($POST['description']);
        $date = date('Y-m-d-h:i:s');
        $user_id = $this->session->userdata['inf_logged_in']['user_id'];
        $user_type = $this->session->userdata['inf_logged_in']['user_type'];

        if ($user_type == "admin")
            $allocate_status = "allocated";
        else
            $allocate_status = "not_allocated";

        $products = $this->table_prefix . 'products';

        if ($action == 'save') {

            $data = array('product_description' => $description,
                'product_features' => $featurs,
                'product' => $product_name,
                'brand' => $brand,
                'price' => $price,
                'tax' => $tax,
                'stock_count' => $product_count,
                'product_image1' => $img_name1,
                'product_image2' => $img_name2,
                'product_image3' => $img_name3,
                'added_user' => $user_id,
                'date_of_entry' => $date,
                'allocate_status' => $allocate_status
            );
            $insQry = $this->db->insert($products, $data);
            $pro_id = $this->db->insert_id();
            // echo $this->db->last_query();die();
            if (!$insQry)
                $res['err'] = 5;
            else {
                if ($user_type == "distributor")
                    $this->insertIntoProductAllocationRequest($user_id, $pro_id);
                $res['err'] = 0;
            }
        }
        if ($action == 'update') {

            $id = $this->session->userdata('inf_pdt_id');
            $this->db->set('product', $product_name);
            $this->db->set('brand', $brand);
            $this->db->set('price', $price);
            $this->db->set('tax', $tax);
            $this->db->set('product_features', $featurs);
            $this->db->set('product_description', $description);
            $this->db->set('product_image1', $img_name1);
            $this->db->set('product_image2', $img_name2);
            $this->db->set('product_image3', $img_name3);
            $this->db->where('id', $id);
            $st = $this->db->update($products);

            if (!$st)
                $res['err'] = 5;
            else
                $res['err'] = 0;
        }
        return $res['err'];
    }

    /* function doProduct($POST, $img_name1, $thumb_name1,$img_code1, $img_name2, $thumb_name2,$img_code2, $img_name3, $thumb_name3,$img_code3,$action)
      {

      $res['err']=0;
      $product_name = addslashes($POST['product_name']);
      $brand = addslashes($POST['brand']);
      $product_category = addslashes($POST['product_category']);
      $product_subcategory = addslashes($POST['product_subcategory']);
      $price = addslashes($POST['price']);
      $tax = addslashes($POST['tax']);
      $featurs = addslashes($POST['featurs']);
      $description = addslashes($POST['description']);
      $date = date('Y-m-d-h:i:s');


      $this->table_prefix="9_";
      $products = $this->table_prefix.'products';
      if($action=='save')
      {
      $data=array('product_description'=>$description,
      'product_features'=>$featurs,
      'product'=>$product_name,
      'brand'=>$brand,
      'price'=>$price,
      'tax'=>$tax,
      'product_image1'=>$img_name1,
      'product_image2'=>$img_name2,
      'product_image3'=>$img_name3,
      'date_of_entry'=>$date);
      $insQry=$this->db->insert($products,$data);


      if(!$st)
      $res['err']=5;
      else
      $res['err']=0;
      }
      if($action=='update')
      {

      $id=$this->session->userdata('inf_pdt_id');
      $this->db->set('product',$product_name);
      $this->db->set('brand',$brand);
      $this->db->set('price',$price);
      $this->db->set('tax',$tax);
      $this->db->set('product_features',$featurs);
      $this->db->set('product_description',$description);
      $this->db->where('id',$id);
      $this->db->update($products);

      if(!$st)
      $res['err']=5;
      else
      $res['err']=0;
      }
      return $res['err'];
      } */

    public function getProducts() {

        //echo "ss=>".$this->table_prefix;
        //$tbl = $this->table_prefix.'ecom_products';
        $tbl = $this->table_prefix . "products";
        /* $selQry = "SELECT * FROM $tbl";
          $res = $this->selectData($selQry,"Error : D11012012T1455PML116"); */

        $selQry = $this->db->get_where($tbl, array('added_user' => $this->session->userdata['inf_logged_in']['user_id']));
        $i = 0;
        if ($selQry->num_rows() > 0) {
            foreach ($selQry->result_array() as $row) {
                $product["product$i"]["id"] = $row['id'];
                //$id = $row['category_id'];
                //$subid = $row['subcategory_id'];
                //$product["product$i"]["category_name"] = $this->getCategoryName($id);
                //$product["product$i"]["subcategory_name"] = $this->getSubCategoryName($subid);
                $product["product$i"]["product"] = $row['product'];
                $product["product$i"]["brand"] = $row['brand'];
                $product["product$i"]["price"] = $row['price'];
                $product["product$i"]["tax"] = $row['tax'];
                $product["product$i"]["description"] = $row['description'];
                $product["product$i"]["date_of_entry"] = $row['date_of_entry'];
                $product["product$i"]["isfeatured"] = $row['isfeatured'];
                $i++;
            }
            return $product;
        }
    }

    function getAvailableBalance($user_id) {

        $this->db->select('balance_amount');
        $query = $this->db->get_where('9_user_balance_amount', array('user_id' => $user_id));
        foreach ($query->result() as $row) {
            return $row->balance_amount;
        }
    }

    function deductPoint($user_id, $point_deduct) {

        $avail_blnce_point = $this->getAvailableBalance($user_id);
        $new_blnce_point = $avail_blnce_point - $point_deduct;
        $this->db->set("balance_amount", round($new_blnce_point, 2));
        $this->db->where('user_id', $user_id);
        $res = $this->db->update('9_user_balance_amount');
        //  echo $this->db->last_query();
        return $res;
    }

    public function getProductForUpdate($id) {
        $products = $this->table_prefix . 'products';
        $query = $this->db->get_where($products, array('id' => $id));

        if ($query->num_rows() == 1) {

            foreach ($query->result_array() as $row) {
                $edit["id"] = $row['id'];
                //$edit["product"]["cid"] = $row['cid'];
                //$edit["product"]["catname"] = $row['catname'];
                //$edit["subcatname"] = $row['subcatname'];
                //$edit["product"]["subcid"] = $row['subcid'];
                $edit["product"]["product"] = $row['product'];
                $edit["product"]["brand"] = $row['brand'];
                $edit["product"]["price"] = $row['price'];
                $edit["product"]["tax"] = $row['tax'];
                $edit["product"]["featurs"] = $row['product_features'];
                $edit["product"]["thumb"] = $row['thumb1'];
                $edit["product"]["description"] = $row['product_description'];
                $edit["product"]["date_of_entry"] = $row['date_of_entry'];
            }
            return $edit;
        }
    }

    public function updateProduct($POST) {

        $name1 = 'product_image1';
        $name2 = 'product_image2';
        $name3 = 'product_image3';
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        extract($POST);
        $image_name1 = $_FILES['product_image1']['name'];
        $image_name2 = $_FILES['product_image2']['name'];
        $image_name3 = $_FILES['product_image3']['name'];

        if ($image_name1 == "") {
            $id = $this->session->userdata('inf_pdt_id');
            $image = $this->getImages($id, 'product', 1);
            $file_name1 = $image['image1'];
            /* $id = $_SESSION['pdt_id'];
              $image = $this->getImages($id, 'product',1);
              $img_name1 = $image['image1'];
              $thumb_name1= $image['thumb1'];
              $code1 = $image['img_code1']; */
        }
        if ($image_name2 == "") {
            $id = $this->session->userdata('inf_pdt_id');
            $image = $this->getImages($id, 'product', 2);
            $file_name2 = $image['image2'];
            /* $id = $_SESSION['pdt_id'];
              $image = $this->getImages($id, 'product',1);
              $img_name1 = $image['image1'];
              $thumb_name1= $image['thumb1'];
              $code1 = $image['img_code1']; */
        }
        if ($image_name3 == "") {
            $id = $this->session->userdata('inf_pdt_id');
            $image = $this->getImages($id, 'product', 3);
            $file_name3 = $image['image3'];
            /* $id = $_SESSION['pdt_id'];
              $image = $this->getImages($id, 'product',1);
              $img_name1 = $image['image1'];
              $thumb_name1= $image['thumb1'];
              $code1 = $image['img_code1']; */
        }

        $config['upload_path'] = './public_html/images/products/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '1000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';

        $this->load->library('upload', $config);
        if ($_FILES['product_image1']['error'] != 4) {
            if (!$this->upload->do_upload('product_image1')) {

                $error = array('error' => $this->upload->display_errors());
                $data['upload_data']['file_name'] = "";
            } else {

                $data = array('upload_data' => $this->upload->data());

                $file_name1 = $data['upload_data']['file_name'];
            }
        }

        if ($_FILES['product_image2']['error'] != 4) {
            if (!$this->upload->do_upload('product_image2')) {

                $error = array('error' => $this->upload->display_errors());
                $data['upload_data']['file_name'] = "";
            } else {

                $data = array('upload_data' => $this->upload->data());
                $file_name2 = $data['upload_data']['file_name'];
            }
        }

        if ($_FILES['product_image1']['error'] != 4) {
            if (!$this->upload->do_upload('product_image3')) {

                $error = array('error' => $this->upload->display_errors());
                $data['upload_data']['file_name'] = "";
            } else {

                $data = array('upload_data' => $this->upload->data());
                $file_name3 = $data['upload_data']['file_name'];
            }
        }
        ;
        $res = $this->doProduct($POST, $file_name1, $file_name2, $file_name3, 'update');

        return $res;
    }

    public function deleteProduct($id) {

        $products = $this->table_prefix . "products";
        $image1 = $this->getImages($id, 'product', 1);
        $del_img1 = $image1['image1'];
        $image2 = $this->getImages($id, 'product', 2);
        $del_img2 = $image1['image2'];
        $image3 = $this->getImages($id, 'product', 3);
        $del_img3 = $image1['image3'];
        $delQry = $this->db->delete($products, array('id' => $id));
        if ($delQry) {
            $this->deleteImage($del_img1);

            $this->deleteImage($del_img2);

            $this->deleteImage($del_img3);

            return 1;
        } else
            return 0;
    }

    public function updateCategory() {
        $name = 'category_image';
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        extract($POST);
        $image_name = $_FILES['category_image']['name'];
        if ($image_name == "") {
            $id = $_SESSION['cat_id'];
            $image = $this->getImages($id, 'category');
            $code = $image['img_code1'];
            $img_name = $image['image1'];
            $res = $this->doCategory($POST, $img_name, $code, 'update');
        } else {
            $res = $this->checkImage($POST, $name, 'categories', 0);
            if ($res['err'] == 0) {
                $filename = $res['filename'];
                $image_name = $res['image_name'];
                $extension = $res['extension'];
                $status = $this->create_thumb($filename, $extension, $image_name, 'category');
                if ($status) {
                    $id = $_SESSION['cat_id'];
                    $image = $this->getImages($id, 'category');
                    $code = $image['img_code'];
                    if ($code == 1) {
                        $del_img = $image['image'];
                        $this->deleteImage($del_img);
                    }
                    $thumb_name = "imgs/categories/" . $image_name;
                    $res = $this->doCategory($POST, $thumb_name, $code, 'update');
                }
            }
        }
        return $res;
    }

    public function updateSubCategory() {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        extract($POST);
        $res = $this->doSubCategory($POST, 'update');
        return $res;
    }

    public function deleteCategory($id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $image = $this->getImages($id, 'category');
        $code = $image['img_code'];
        if ($code == 1) {
            $del_img = $image['image'];
        }
        $tbl = $this->table_prefix . 'ecom_category';
        $delQry = "DELETE FROM $tbl WHERE id='$id'";
        $res = $this->deleteData($delQry, 'Error : 987456321');
        if ($res) {
            $this->deleteImage($del_img);
            return 1;
        } else
            return 0;
    }

    public function deleteSubCategory($id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }

        $tbl = $this->table_prefix . 'ecom_subcategory';
        $delQry = "DELETE FROM $tbl WHERE subcategory_id='$id'";
        $res = $this->deleteData($delQry, 'Error : 987456321');
        if ($res) {
            return 1;
        } else
            return 0;
    }

    function doCategory($POST, $thumb_name, $code, $action) {
        $category_name = addslashes($POST['category_name']);
        $categorytbl = $this->table_prefix . 'ecom_category';
        $date = date('Y-m-d-h:i:s');
        echo "$action";
        if ($action == 'save') {
            $insQry = "INSERT INTO $categorytbl (category, image, img_code, date_of_entry) VALUES ('$category_name','$thumb_name',$code,'$date')";
            $res = $this->insertData($insQry, 'Error : D11012012T1418PML116');
        }
        if ($action == 'update') {
            $id = $_SESSION['cat_id'];
            $upQry = "UPDATE $categorytbl SET category='$category_name', image='$thumb_name', img_code='$code' WHERE id='$id'";
            $st = $this->updateData($upQry, 'Error : D11012012T1247PML99');
            $_SESSION['pdt_id'] = "";
            if (!$st)
                $res['err'] = 5;
            else
                $res['err'] = 0;
        }
        if (!$res) {
            return 5;
        }
    }

    function doSubCategory($POST, $action) {
        $subcategory_name = addslashes($POST['subcategory_name']);
        $category_id = addslashes($POST['product_category']);
        $subcategorytbl = $this->table_prefix . 'ecom_subcategory';
        $date = date('Y-m-d-h:i:s');
//echo "$action";
        if ($action == 'save') {
            $insQry = "INSERT INTO $subcategorytbl (subcategory_name,category_id,date_of_entry) VALUES ('$subcategory_name','$category_id','$date')";
            $res = $this->insertData($insQry, 'Error : D11012012T1418PML116');
        }
        if ($action == 'update') {
            $id = $_SESSION['subcat_id'];
            $upQry = "UPDATE $subcategorytbl SET subcategory_name='$subcategory_name',category_id='$category_id' WHERE subcategory_id='$id'";
            $st = $this->updateData($upQry, 'Error : D11012012T1247PML99');
            $_SESSION['pdt_id'] = "";
            if (!$st)
                $res['err'] = 5;
            else
                $res['err'] = 0;
        }
        if (!$res) {
            return 5;
        }
    }

    public function getCategory() {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $tbl = $this->table_prefix . 'ecom_category';
        $selQry = "SELECT * FROM $tbl ORDER BY category asc";
        $res = $this->selectData($selQry, "Error : D11012012T1434PML151");
        $i = 0;
        while ($row = mysql_fetch_array($res)) {
            $category["cat$i"]['id'] = $row['id'];
            $category["cat$i"]['category'] = $row['category'];
            $category["cat$i"]['image'] = $row['image'];
            $category["cat$i"]['date_of_entry'] = $row['date_of_entry'];
            $i++;
        }
        return $category;
    }

    public function getSubCategory() {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $tbl1 = $this->table_prefix . 'ecom_subcategory';
        $tbl2 = $this->table_prefix . 'ecom_category';
        $selQry = "SELECT sc.subcategory_id, sc.subcategory_name, c.category, sc.date_of_entry
		FROM $tbl1 AS sc
		LEFT JOIN $tbl2 AS c ON sc.category_id = c.id
	 	ORDER BY sc.subcategory_name asc";
        $res = $this->selectData($selQry, "Error : D11012012T1434PML151");
        $i = 0;
        while ($row = mysql_fetch_array($res)) {
            $category["cat$i"]['subcategory_id'] = $row['subcategory_id'];
            $category["cat$i"]['subcategory_name'] = $row['subcategory_name'];
            $category["cat$i"]['category'] = $row['category'];
            $category["cat$i"]['date_of_entry'] = $row['date_of_entry'];
            $i++;
        }
        return $category;
    }

    public function selectSub($id) {

        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $tbl = $this->table_prefix . 'ecom_subcategory';
        $sqlQry = "select * from $tbl where category_id=$id";

        $res = $this->selectData($sqlQry, "Error : D11012012T1434PML152");
        $i = 0;
        while ($row = mysql_fetch_array($res)) {
            $category["cat$i"]['subcategory_id'] = $row['subcategory_id'];
            $category["cat$i"]['subcategory_name'] = $row['subcategory_name'];
            $i++;
        }
        return $category;
    }

    public function getCategoryName($id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $tbl = $this->table_prefix . 'ecom_category';
        $qry = "SELECT category FROM $tbl WHERE id='$id'";
        $res = $this->selectData($qry, 'Error on selecting category name!');
        $row = mysql_fetch_array($res);
        return $row['category'];
    }

    public function getSubCategoryName($id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $tbl = $this->table_prefix . 'ecom_subcategory';
        $qry = "SELECT subcategory_name FROM $tbl WHERE subcategory_id='$id'";
        $res = $this->selectData($qry, 'Error on selecting Subcategory name!');
        $row = mysql_fetch_array($res);
        return $row['subcategory_name'];
    }

    public function getCategoryForUpdate($id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $tbl = $this->table_prefix . 'ecom_category';
        $qry = "SELECT * FROM $tbl WHERE id='$id'";
        $res = $this->selectData($qry, "Error on selecting category");
        $row = mysql_fetch_array($res);
        $category["cat"]['id'] = $row['id'];
        $category["cat"]['category'] = $row['category'];
        $category["cat"]['description'] = $row['description'];
        return $category;
    }

    public function getSubCategoryForUpdate($id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $tbl = $this->table_prefix . 'ecom_subcategory';
        $qry = "SELECT * FROM $tbl WHERE subcategory_id='$id'";
        $res = $this->selectData($qry, "Error on selecting subcategory");
        $row = mysql_fetch_array($res);
        $category["subcat"]['subcategory_id'] = $row['subcategory_id'];
        $category["subcat"]['sub_categoryname'] = $row['subcategory_name'];
        $category["subcat"]['category_id'] = $row['category_id'];
        return $category;
    }

    function checkImage($POST, $name, $folder, $no) {


        $root = base_url();
        $ipath = $root . "public_html/images/$folder/";
        //echo "aaaaaaa $name";
        //echo "$ipath";
        //echo $image=$_FILES[$name]['tmp_name'];
        //  echo "$image";
        $filename = stripslashes($_FILES[$name]['name']);
        //echo "File Name:$filename ";
        $img_property = list($width1, $height1, $image1_type) = getimagesize($image);
        $w = $img_property[0];
        $h = $img_property[1];
        //echo "$w.$h";
        $size = filesize($_FILES[$name]['tmp_name']);
        //echo "$size";die();
        $extension = $this->getExtension($filename);
        $extension = strtolower($extension);
        // echo $extension;
        if ($extension != 'png' && $extension != 'gif' && $extension != 'jpg' && $extension != 'jpeg') {
            $res['err'] = 1; // for extension
        }
        /* else if($w > 900)
          {
          $res['err']= 2; // for width
          }
          else if($h > 900)
          {
          $res['err'] = 3; // for height
          }
          else if($size > 512000)
          {
          $res['err'] = 4; // for size max 500kb
          } */ else {
            $image_name = $this->table_prefix . date("Y-m-d") . "_" . time() . $no . '.' . $extension;
            //echo "$image_name";die();
            //copy ($_FILES[$name]['tmp_name'],$ipath.$image_name);
            //echo "Path:$ipath.$image_name";
            if ((!copy($_FILES[$name]['tmp_name'], $ipath . $image_name))) {
                //echo "failed";
            } else {
                echo "success";
            }
            $filename = $ipath . $image_name; // original image path
            //added by ashique for return image object correctly

            $res['err'] = 0;
            $res['filename'] = $filename;
            $res['image_name'] = $image_name;
            $res['extension'] = $extension;

//echo "aaaaa$filename.$image_name. $extension aaaa";
        }
        return $res;
    }

    function getExtension($str) {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    function create_thumb($image1_path, $ex, $image_name, $type) {

        //$root = ROOT;
        $root = base_url();
        if ($type == 'product') {
            $tpath = $root . '/public_html/images/products/thumbs/';
            //$tpath = $root.'/application/views/imgs/products/thumbs/';
        }
        if ($type == 'category') {
            $tpath = $root . '/application/views/imgs/categories/';
        }
        $box = 210;
        list($width1, $height1, $image1_type) = getimagesize($image1_path);
        $image2_path = $tpath . $image_name; //thumbs path

        if ($width1 > $box || $height1 > $box) {
            echo "<br>if block";
            $width2 = $height2 = $box;

            if ($width1 < $height1)
                $width2 = round(($box / $height1) * $width1);
            else
                $height2 = round(($box / $width1) * $height1);
            // set image type, blending and set functions for gif, jpeg and png
            switch ($image1_type) {
                case IMAGETYPE_PNG: $img = 'png';
                    $blending = false;
                    break;
                case IMAGETYPE_GIF: $img = 'gif';
                    $blending = true;
                    break;
                case IMAGETYPE_JPEG: $img = 'jpeg';
                    break;
            }
            $imagecreate = "imagecreatefrom$img";
            $imagesave = "image$img";
            // initialize image from the file
            $image1 = $imagecreate($image1_path);
            // create a new true color image with dimensions $width2 and $height2
            $image2 = imagecreatetruecolor($width2, $height2);
            // preserve transparency for PNG and GIF images
            if ($img == 'png' || $img == 'gif') {
                // allocate a color for thumbnail
                $background = imagecolorallocate($image2, 0, 0, 0);
                // define a color as transparent
                imagecolortransparent($image2, $background);
                // set the blending mode for thumbnail
                imagealphablending($image2, $blending);
                // set the flag to save alpha channel
                imagesavealpha($image2, true);
            }
            // save thumbnail image to the file
            echo $image2 . "sss" . $image2_path;
            imagecopyresampled($image2, $image1, 0, 0, 0, 0, $width2, $height2, $width1, $height1);
            $imagesave($image2, $image2_path);
        }
        // else just copy the image
        else {
//echo "<br>else block";		
            copy($image1_path, $image2_path);
        }
        return true;
    }

    function deleteImage($img) {
        //$root = ROOT;
        //$tpath = $root.'/application/views/';
        $tpath = './public_html/images/products/' . $img;
        unlink($tpath);
    }

    function getImages($id, $item, $no) {
        $products = $this->table_prefix . "products";
        if ($item == 'product') {
            $selQry = $this->db->get_where($products, array('id' => $id));
            if ($selQry->num_rows() > 0) {
                foreach ($selQry->result_array() as $row) {
                    $image["image$no"] = $row["product_image$no"];
                }
                return $image;
            }
            /* $products = $this->table_prefix.'ecom_products';
              $selQry = "SELECT thumb$no, image$no, img_code$no FROM $products WHERE id='$id'";
              $res = $this->selectData($selQry,"Error : D12012012T1226PML459");
              $row = mysql_fetch_array($res);
              $image["thumb$no"]=$row["thumb$no"];
              $image["image$no"]=$row["image$no"];
              $image["img_code$no"]=$row["img_code$no"]; */
        }
        if ($item == 'category') {
            $categorytbl = $this->table_prefix . 'ecom_category';
            $selQry = "SELECT image, img_code FROM $categorytbl WHERE id='$id'";
            $res = $this->selectData($selQry, "Error : D12012012T1230PML459");
            $row = mysql_fetch_array($res);
            $image["image"] = $row['image'];
            $image["img_code"] = $row['img_code'];
            return $image;
        }
    }

    public function selectProducts($letters) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $products = $this->table_prefix . 'ecom_products';
        $selQry = "SELECT * FROM $products WHERE product LIKE '%$letters%'";
        $res = $this->selectData($selQry, "Error on user selection");
        $cnt = count($inf);
        $str = "";
        $i = 0;
        while ($inf = mysql_fetch_array($res)) {
            $str.= $inf["id"] . "###" . $inf["product"] . "|";
        }
        return $str;
    }

    public function searchProducts($term) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $products = $this->table_prefix . 'ecom_products';
        //$selQry = "SELECT * FROM $tbl ORDER BY product asc";
        $selQry = "SELECT DISTINCT * FROM $products WHERE product LIKE '%$term%'";
        $res = $this->selectData($selQry, "Error : D11012012T1455PML116");
        $i = 0;
        while ($row = mysql_fetch_array($res)) {
            $product["product$i"]["id"] = $row['id'];
            $id = $row['category_id'];
            $product["product$i"]["category_name"] = $this->getCategoryName($id);
            $product["product$i"]["product"] = $row['product'];
            $product["product$i"]["brand"] = $row['brand'];
            $product["product$i"]["price"] = $row['price'];
            $product["product$i"]["tax"] = $row['tax'];
            $product["product$i"]["date_of_entry"] = $row['date_of_entry'];
            $i++;
        }
        return $product;
    }

    public function getJsonProduct($id) {
        $products = $this->table_prefix . "products";
        $selQry = $this->db->get_where($products, array('id' => $id));
        if ($selQry->num_rows() > 0) {
            foreach ($selQry->result() as $row) {
                $details['product'] = $row->product;
                $details['featurs'] = $row->product_features;
                $details['description'] = $row->product_description;
                $details['thumb'] = $row->product_image1;
            }
            $result = json_encode($details);
            return $result;
        }
        /* if($this->table_prefix == "")
          {
          $this->table_prefix =$_SESSION['table_prefix'];
          }
          $products = $this->table_prefix.'ecom_products';
          $selQry = "SELECT product, featurs, description, thumb1 FROM $products WHERE id='$id'";
          $res = $this->selectData($selQry,"Error : D11012012T1455PML116");
          while($row = mysql_fetch_array($res))
          {
          $details['product'] = $row['product'];
          $details['featurs'] = $row['featurs'];
          $details['description'] = $row['description'];
          $details['thumb'] = $row['thumb1'];
          }
          $result=json_encode($details);
          return $result; */
    }

    public function getJsonCategory($id) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $category = $this->table_prefix . 'ecom_category';
        $selQry = "SELECT image FROM $category WHERE id='$id'";
        $res = $this->selectData($selQry, "Error : D11012012T1455PML116");
        while ($row = mysql_fetch_array($res)) {
            $details['image'] = $row['image'];
        }
        $result = json_encode($details);
        return $result;
    }

    public function updateFeaturedProduct($POST) {
        if ($this->table_prefix == "") {
            $this->table_prefix = $_SESSION['table_prefix'];
        }
        $products = $this->table_prefix . 'ecom_products';
        extract($POST);
        $cnt = addslashes($POST['cnt']);
        $i = 0;
        //echo $cnt;
        $upQry = "UPDATE $products SET isfeatured=0";
        $st = $this->updateData($upQry, 'Error : D11012012T1247PML100');
        while ($i < $cnt) {
            $pid = addslashes($POST["pid$i"]);
            $chkd = addslashes($POST["ftrd$i"]);
            // echo $chkd." ".$pid;
            if ($chkd == "on") {
                //echo $chkd." ".$pid;
                $upQry = "UPDATE $products SET isfeatured=1 WHERE id='$pid'";
                $st = $this->updateData($upQry, 'Error : D11012012T1247PML100');
            }
            $i++;
            $res = 1;
        }
    }

    function insertIntoProductAllocationRequest($user_id, $pro_id) {
        $date = date('Y-m-d H:i:s');
        $product_allocation_request = $this->table_prefix . 'product_allocation_request';
        $this->db->set('prod_id', $pro_id);
        $this->db->set('user_id', $user_id);
        $this->db->set('requested_date', $date);
        $res = $this->db->insert($product_allocation_request);
        //  echo $this->db->last_query();die();
        return $res;
    }

}

?>
