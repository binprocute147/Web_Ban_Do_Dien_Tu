@extends('app')
@section('content')
    <style>
        .body-lienhe {
            margin: 30px 50px 50px 50px;
            width: 90%;

        }

        .lienhe-header {
            height: 40px;
            font-weight: bold;
            line-height: 40px;
            padding-left: 10px;
            background: pink;
        }

        .lienhe-info {
            margin: 20px auto 0;
            display: inline-block;
            width: 100%;
        }

        .info-left {
            float: left;
            width: 48%;
        }

        .info-right {
            float: right;
            width: 48%;
        }

        iframe {
            border: 1px solid gray;
        }
    </style>
    <section style="min-height: 85vh">
        <div class="body-lienhe">
            <div class="lienhe-header">Liên hệ</div>
            <div class="lienhe-info">
                <div class="info-left">
                    <p>
                    <h2 style="color: gray">Website bán đồ điện tử </h2><br />
                    <b>Địa chỉ:</b> 53 Võ Văn Ngân, Phường Linh Chiểu, Thành phố Thủ Đức<br /><br />
                    <b>Telephone:</b> 028 3835 4409<br /><br />
                    <b>Website:</b> <a style="text-decoration: none;"
                        href="https://github.com/binprocute147/Web_Ban_Do_Dien_Tu.git">Github</a> <br /><br />
                    <b>E-mail:</b> shigeotokubin@gmail.com<br /><br />
                </div>
                <div class="info-right">
                    <iframe width="100%" height="450"
                        src="https://maps.google.com/maps?width=100%&height=450&hl=en&coord=10.759660000323064,106.68192160315813&q=Tr%C6%B0%E1%BB%9Dng%20Cao%20%C4%90%E1%BA%B3ng%20C%C3%B4ng%20Ngh%E1%BB%87%20Th%E1%BB%A7%20%C4%90%E1%BB%A9c&ie=UTF8&t=&z=16&iwloc=B&output=embed"
                        frameborder="0" scrolling="no" marginheight="0" marginwidth="0"><a
                            href="https://www.maps.ie/create-google-map/">Embed
                            Google Map
                        </a>
                    </iframe>
                    <br />
                </div>
            </div>
        </div>
    </section>
@endsection
