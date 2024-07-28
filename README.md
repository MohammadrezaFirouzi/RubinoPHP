<p align="center">
<a href='https://web.rubika.ir' target="_blank">
<img src='https://bahramali.ir/img/rubika.logo.svg'></img></a></p>
<br />
</p>

# کتابخانه روبیکا  PHP  (روبینو)😅
<br/>



## اضافه کردن کتابخونه به پروژه 🎊 :
```php
require_once(
    './rubino/rubino.php'
);
```

<br>

## وارد کردن اطلاعات اکانت  :
```php
<?php 

require_once(
    './rubino/rubino.php'
);
$bot = new RubinoPHP("AUTH"); // Login web2.rubika.ir and get AUTH Rubino Tab

```


## استفاده از متد ها  :
```php
<?php 

require_once(
    './rubino/rubino.php'
);
$bot = new RubinoPHP("AUTH");

print_r($bot->getPostByShareLink("https://rubika.ir/post/pdhDVDMDXw"));

?>


```

## مدیریت خطا ها :

#### اضافه کردن کلاس به پروژه
```php
require_once(
    './rubino/exception.php'
);
```
#### مثال :

```php
}catch(InvalidInput $e){}

catch(NotRegistered $e){}

catch(InvalidAuth $e){}

catch(TooRequests $e){}
```


## همگام سازی یک مثال دیگر :
```php 
<?php


require_once(
    './rubino/rubino.php'
);
require_once(
    './network/exception.php'
);

$bot = new RubinoPHP("AUTH");

try {
    print_r($bot->getMyProfileInfo());
} catch (InvalidInput $e) {
    print("ورودی نامعتبر میباشد ");
} catch (NotRegistered $e) {
    echo "اکانت نامعتبر است";
} catch (TooRequests $e) {
    echo "اکانت شما محدود شده است";
}

?>


```


## نمونه ربات دانلود از روبینو :
```php
<?php


require_once(
    './rubino/rubino.php'
);
require_once(
    './network/exception.php'
);

$bot = new RubinoPHP("AUTH");

try {

    $post_data = $bot->getPostByShareLink("https://rubika.ir/post/pdhDVDMDXw");
    
    echo $post_data['data']['post']['full_file_url']; // لینک دانلود پست 

} catch (InvalidInput $e) {
    print("ورودی نامعتبر میباشد ");
} catch (NotRegistered $e) {
    echo "اکانت نامعتبر است";
} catch (TooRequests $e) {
    echo "اکانت شما محدود شده است";
}



```

<a href="https://www.coffeebede.com/mohammadrezafirouzii"><img class="img-fluid" src="https://coffeebede.ir/DashboardTemplateV2/app-assets/images/banner/default-yellow.svg" /></a>



