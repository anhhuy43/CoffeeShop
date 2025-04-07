<?php include(__DIR__ . '/../shares/header.php'); ?>

<section layout:fragment="content" class="container">
    <div class="products">
        <div class="panel panel-prod">
            <div class="panel-heading panel-heading-prod" style="text-align:center;font-size: 2.5rem;margin: 70px;font-weight: 500;">Thông tin cửa hàng</div>
            <div class="contact-info text-center">
                <p style="text-align:center">&nbsp;</p>
                <p style="text-align:center"><iframe align="middle" frameborder="0" height="800" scrolling="yes" src="https://docs.google.com/spreadsheets/d/e/2PACX-1vRHhHAYPJsF2FYxHexn4lcHKTCi9BtRgku_F31od9cppdK9GB27VJkaEHwKit5cWQ/pubhtml?widget=true&amp;headers=false" width="1000"></iframe></p>
                <p>&nbsp;</p>
                <p>Tên chính thức:&nbsp;<strong>C</strong><strong>ÔNG TY CỔ PHẦN PHÚC LONG HERITAGE</strong></p>
                <p>Trụ sở chính: Phòng 702, Tầng 7, Tòa nhà Central Plaza, Số 17 Đường Lê Duẩn, Phường Bến Nghé, Quận 1, Tp. HCM</p>
                <p>Mã số thuế/GPKD:&nbsp;0316&nbsp;871719</p>
                <p>Điện thoại:&nbsp;(+84 28) 6263 0377 - 6263 0378</p>
                <p>Email:&nbsp;marketing@phuclong.com.vn</p>
            </div>
        </div>
        <div class="panel panel-prod">
            <div class="panel-heading panel-heading-prod" >Phản hồi với Phúc Long</div>
            <div class="panel-body">
                <div class="panel panel-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-2" for="txtusername">Họ và tên:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="txtusername" placeholder="Nhập họ và tên">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2" for="txtemail">Email:</label>
                            <div class="col-md-12">
                                <input type="email" class="form-control" id="txtemail" placeholder="Nhập địa chỉ email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2" for="txttitle">Tiêu đề:</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control" id="txttitle" placeholder="Nhập tiêu đề">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2" for="txtdetail">Nội dung:</label>
                            <div class="col-md-12">
                                <textarea class="form-control" id="txtdetail" rows="5" placeholder="Nhập nội dung"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-12">
                                <button type="submit" id="btnSend" class="btn btn-danger" style="color: white;"><i class="fa fa-external-link"></i> Gửi </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
        .form-group{
        margin-bottom: 20px;
        }
        .panel-heading{
        text-align: center;
        font-weight: 700;
        font-size: 1.5rem;
        margin: 50px 0 20px;
        text-transform: uppercase;
        }
</style>
<?php include(__DIR__ . '/../shares/footer.php'); ?>

<script>
document.getElementById('contact-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('/DA_MaNguonMo/home/contact', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === 'Contact form submitted successfully') {
            alert('Gửi tin nhắn thành công');
        } else {
            alert('Gửi tin nhắn thất bại');
        }
    });
});
</script>
