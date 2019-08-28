$(document).ready(function() {
    $('#installation').submit(function (e) {
        $('#notification').html('<div class="bar"</div>');
        e.preventDefault();
        $.ajax({
            type:'POST',
            data: $('form#installation').serialize(),
            statusCode: {
                200: function (data) {
                    $('#notification').html("                    <div class=\"alert alert-primary\" role=\"alert\">\n" +
                        "                        Uspesno ste instalirali aplikaciju, kako bi ste krenuli da je koristite idite na <strong>domen.com/students/ID</strong> (ID je od 1 do 45)!\n" +
                        "                    <hr />Molimo obrisite instalacioni direktorijum <strong>installation/</strong></div>\n");
                    $('#installation').remove();
                },
                404: function (data) {
                    $('#notification').html("                    <div class=\"alert alert-danger\" role=\"alert\">\n" +
                        "                        <strong>Greska!</strong> Doslo je do greske prilikom instalacije!\n" +
                        "                    </div>\n");
                },
                500: function (data) {
                    $('#notification').html("                    <div class=\"alert alert-danger\" role=\"alert\">\n" +
                        "                        <strong>Greska!</strong> Doslo je do greske prilikom instaliranja konfiguracionih fajlova.!\n" +
                        "                    <hr />Molimo unesite sledece komande kroz terminal, da bi mogli da nastavite dalje <br /><br /><div class='alert alert-dark'><code >chown www-data:www-data 'your-www-folder-location'<br /> chmod -R 775 'your-www-folder-location'</code></div></div>\n");
                },
                403: function (data) {
                    $('#notification').html("                    <div class=\"alert alert-danger\" role=\"alert\">\n" +
                        "                        <strong>Greska!</strong> Nismo uspeli da kreiramo tabelu!\n" +
                        "                    </div>\n");
                },
                405: function (data) {
                    $('#notification').html("                    <div class=\"alert alert-danger\" role=\"alert\">\n" +
                        "                        <strong>Greska!</strong> Podatci za bazu podataka nisu validni!\n" +
                        "                    </div>\n");
                }
            }
        })
    });
});