$(document).on('click', '.open-image', function (e) {
    $('#shw-img').addClass('gall');
    $('#shw-img').removeClass('sert');
    $('#shw-img').modal('show');
    if ($('*').is('#imageListInput')) {
        var valArray = $('#imageListInput').val();
        if (valArray != '') {
            var arrayDataSet = JSON.parse(valArray);

            for (let item in arrayDataSet['array']) {

                console.log(arrayDataSet['array'][item]);
                $('.imagecheck-input[value="' + arrayDataSet['array'][item]['value'] + '"]').attr('checked', true);
            }
        }
    }
});


$(document).on('click', '.open-image-ser', function (e) {
    $('#shw-img').addClass('sert');
    $('#shw-img').removeClass('gall');
    $('#shw-img').modal('show');
    if ($('#imageListInputSer')) {
        var valArray = $('#imageListInputSer').val();
        if (valArray != '') {
            var arrayDataSet = JSON.parse(valArray);

            for (let item in arrayDataSet['array']) {

                console.log(arrayDataSet['array'][item]);
                $('.imagecheck-input[value="' + arrayDataSet['array'][item]['value'] + '"]').attr('checked', true);
            }
        }
    }
});



WebFont.load({
    google: { "families": ["Lato:300,400,700,900"] },
    custom: { "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['/adminStyle/assets/css/fonts.min.css'] },
    active: function () {
        sessionStorage.fonts = true;
    }
});

Circles.create({
    id: 'circles-1',
    radius: 45,
    value: 60,
    maxValue: 100,
    width: 7,
    text: 5,
    colors: ['#f1f1f1', '#FF9E27'],
    duration: 400,
    wrpClass: 'circles-wrp',
    textClass: 'circles-text',
    styleWrapper: true,
    styleText: true
})

Circles.create({
    id: 'circles-2',
    radius: 45,
    value: 70,
    maxValue: 100,
    width: 7,
    text: 36,
    colors: ['#f1f1f1', '#2BB930'],
    duration: 400,
    wrpClass: 'circles-wrp',
    textClass: 'circles-text',
    styleWrapper: true,
    styleText: true
})

Circles.create({
    id: 'circles-3',
    radius: 45,
    value: 40,
    maxValue: 100,
    width: 7,
    text: 12,
    colors: ['#f1f1f1', '#F25961'],
    duration: 400,
    wrpClass: 'circles-wrp',
    textClass: 'circles-text',
    styleWrapper: true,
    styleText: true
})

// var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

// var mytotalIncomeChart = new Chart(totalIncomeChart, {
//     type: 'bar',
//     data: {
//         labels: ["S", "M", "T", "W", "T", "F", "S", "S", "M", "T"],
//         datasets: [{
//             label: "Total Income",
//             backgroundColor: '#ff9e27',
//             borderColor: 'rgb(23, 125, 255)',
//             data: [6, 4, 9, 5, 4, 6, 4, 3, 8, 10],
//         }],
//     },
//     options: {
//         responsive: true,
//         maintainAspectRatio: false,
//         legend: {
//             display: false,
//         },
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     display: false //this will remove only the label
//                 },
//                 gridLines: {
//                     drawBorder: false,
//                     display: false
//                 }
//             }],
//             xAxes: [{
//                 gridLines: {
//                     drawBorder: false,
//                     display: false
//                 }
//             }]
//         },
//     }
// });

$('#lineChart').sparkline([105, 103, 123, 100, 95, 105, 115], {
    type: 'line',
    height: '70',
    width: '100%',
    lineWidth: '2',
    lineColor: '#ffa534',
    fillColor: 'rgba(255, 165, 52, .14)'
});



function translit(word) {
    var answer = "";
    var converter = {
        а: "a",
        б: "b",
        в: "v",
        г: "g",
        д: "d",
        е: "e",
        ё: "e",
        ж: "zh",
        з: "z",
        и: "i",
        й: "y",
        к: "k",
        л: "l",
        м: "m",
        н: "n",
        о: "o",
        п: "p",
        р: "r",
        с: "s",
        т: "t",
        у: "u",
        ф: "f",
        х: "h",
        ц: "c",
        ч: "ch",
        ш: "sh",
        щ: "sch",
        ь: "",
        ы: "y",
        ъ: "",
        э: "e",
        ю: "yu",
        я: "ya",
        А: "a",
        Б: "b",
        В: "v",
        Г: "g",
        Д: "d",
        Е: "e",
        Ё: "e",
        Ж: "zh",
        З: "z",
        И: "i",
        Й: "y",
        К: "k",
        Л: "l",
        М: "m",
        Н: "n",
        О: "o",
        П: "p",
        Р: "r",
        С: "s",
        Т: "t",
        У: "u",
        Ф: "f",
        Х: "h",
        Ц: "c",
        Ч: "ch",
        Ш: "sh",
        Щ: "sch",
        Ь: "",
        Ы: "y",
        Ъ: "",
        Э: "e",
        Ю: "yu",
        Я: "ya",
        " ": "-",
        "  ": "-",
        _: "-",
        "!": "",
        "?": "",
        "\"": "",
        "'": "",

    };

    for (var i = 0; i < word.length; ++i) {
        if (converter[word[i]] == undefined) {
            answer += word[i];
        } else {
            answer += converter[word[i]];
        }
    }

    return answer;
}


function rus_to_latin(str) {
    var ru = {
        'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd',
        'е': 'e', 'ё': 'e', 'ж': 'j', 'з': 'z', 'и': 'i',
        'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
        'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u',
        'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh',
        'щ': 'shch', 'ы': 'y', 'э': 'e', 'ю': 'u', 'я': 'ya',
        'ъ': 'ie', 'ь': '', 'й': 'i', ' ': '-', '"': '', '\'': '', '_': '-', '(': '', ')': ''
    }, n_str = [];

    for (var i = 0; i < str.length; ++i) {
        n_str.push(
            ru[str[i]]
            || ru[str[i].toLowerCase()] == undefined && str[i]
            || ru[str[i].toLowerCase()].replace(/^(.)/, function (match) { return match.toUpperCase() })
        );
    }
    return n_str.join('');
}

$(document).ready(function () {
    $(document).on('click', '.remove-image', function (e) {
        var index = $(this).data('id'),
            imgData = $('#imageListInput').val(),
            array = JSON.parse(imgData),
            arraySet = array['array'];
        dataArray = {},
            newArray = {},
            s = 1;

        delete arraySet[index];
        for (let item in arraySet) {
            if (arraySet[item] != null) {
                newArray[s] = arraySet[item];
                s++;
            }
        }
        dataArray['array'] = newArray;
        $('#imageListInput').val(JSON.stringify(dataArray));
        $('.img-element-' + index).remove();
    });
});

$(document).on('click', '#shw-img .btn-close', function (e) {
    $('.imagecheck-input').attr('checked', false);
})


$(document).on('submit', '#imageList', function (e) {
    e.preventDefault();
    var array = $('#imageList').serializeArray();
    $.post('/admin/product/image-list', { array: array }, Success);
    function Success(data) {
        if ($("#shw-img").hasClass("gall")) {
            $('#shw-img').modal('hide');
            $('#imageListInput').val(data.data);
            $('.img-prew').html(data.render);
            $("#shw-img").removeClass("gall");
        }
        if($("#shw-img").hasClass("sert")){
            $('#shw-img').modal('hide');
            $('#imageListInputSer').val(data.data);
            
            $('.img-prew-ser').html(data.render);
            $("#shw-img").removeClass("sert");
        }

        if($('*').is('#infostep-img')){
            $('#shw-img').modal('hide');
            $('#infostep-img').val(data.data);
        }

        $('.imagecheck-input').attr('checked', false);

    }
});