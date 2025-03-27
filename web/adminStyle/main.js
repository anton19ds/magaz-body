$(document).on('change', '.data-main-image', function (e) {
    var set = $(this);
    var val = $(this).val();
    var arrayDataSet = JSON.parse($('#imageListInput').val());
    for (let item in arrayDataSet['array']) {
        if (item == val) {
            arrayDataSet['array'][item]['main'] = true;
        } else {
            arrayDataSet['array'][item]['main'] = false;
        }
    }
    $('#imageListInput').val(JSON.stringify(arrayDataSet));
    console.log(arrayDataSet);
});


$(document).on('change', '#set-lavel-user', function (e) {
    $.post('/admin/user/update-lavel', { id: $(this).val(), userId: $(this).data('userid') }, function Success(data) {
        console.log(data);
        if (data) {
            alert('Ok');
        }
    })
})


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





$(document).on('click', '.logo-image', function (e) {
    $('#shw-img').addClass('add-logo');
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



$(document).on('click', '.banner-image', function (e) {
    $('#shw-img').addClass('add-banner');
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
        'ъ': 'ie', 'ь': '', 'й': 'i', ' ': '-', '"': '', '\'': '', '_': '-', '(': '', ')': '', '-\'-': '-', '-/-': '-', '/': ''
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
            $('#imageListInput').val(data.data);
            $('.img-prew').html(data.render);
            $("#shw-img").removeClass("gall");
        }
        if ($("#shw-img").hasClass("sert")) {
            $('#imageListInputSer').val(data.data);
            $('.img-prew-ser').html(data.render);
            $("#shw-img").removeClass("sert");
        }
        if ($('*').is('#infostep-img')) {
            $('#infostep-img').val(data.data);
        }
        if ($('#categoryinfoproduct-img').length) {
            $('#categoryinfoproduct-img').val(data.data);
        }
        if ($('#main-banner').length && $("#shw-img").hasClass('add-banner')) {
            $("#shw-img").removeClass('add-banner')
            $('#main-banner').val(data.data);
        }

        if ($('#main-banner').length && $("#shw-img").hasClass('add-logo')) {
            $("#shw-img").removeClass('logo')
            $('#logo').val(data.data);
        }
        
        $('#shw-img').modal('hide');
        console.log(data.data);

        $('.imagecheck-input').attr('checked', false);

    }
});

$('.selected-status').on('change', function (e) {
    var confirmF = confirm('Сменить стутус заказа?');
    if (confirmF) {
        $.post("/admin/orders/update-status", { id: $(this).data('id'), value: $(this).val() }, function Success(data) {
        });
    }
    document.location = document.location;
});


$(document).ready(function () {
    if ($('#ajaxCrubModal').length > 0 && $('#ajaxCrudModal').length == 0) {
        modal = new ModalRemote('#ajaxCrubModal');
    } else {
        modal = new ModalRemote('#ajaxCrudModal');
    }
    //modalOperator = new ModalRemote('#ajaxOperatorModal');
    // Catch click event on all buttons that want to open a modal
    $(document).on('click', '[role="modal-remote"]', function (event) {
        event.preventDefault();

        // Open modal
        modal.open(this, null);
    });
});

(function ($) {
    $.fn.hasAttr = function (name) {
        return this.attr(name) !== undefined;
    };
}(jQuery));


function ModalRemote(modalId) {
    this.defaults = {
        okLabel: "OK",
        executeLabel: "Execute",
        cancelLabel: "Закрыть",
        loadingTitle: "Loading"
    };
    this.modal = $(modalId);
    this.dialog = $(modalId).find('.modal-dialog');
    this.header = $(modalId).find('.modal-header');
    this.content = $(modalId).find('.modal-body');
    this.footer = $(modalId).find('.modal-footer');
    this.loadingContent = '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>';


    /**
     * Show the modal
     */
    this.show = function () {
        this.clear();
        $(this.modal).modal('show');
    };

    /**
     * Hide the modal
     */
    this.hide = function () {
        $(this.modal).modal('hide');
    };

    /**
     * Toogle show/hide modal
     */
    this.toggle = function () {
        $(this.modal).modal('toggle');
    };

    /**
     * Clear modal
     */
    this.clear = function () {
        $(this.modal).find('.modal-title').remove();
        $(this.content).html("");
        $(this.footer).html("");
    };

    /**
     * Set size of modal
     * @param {string} size large/normal/small
     */
    this.setSize = function (size) {
        $(this.dialog).removeClass('modal-lg');
        $(this.dialog).removeClass('modal-sm');
        if (size == 'large')
            $(this.dialog).addClass('modal-lg');
        else if (size == 'small')
            $(this.dialog).addClass('modal-sm');
        else if (size !== 'normal')
            console.warn("Undefined size " + size);
    };

    /**
     * Set modal header
     * @param {string} content The content of modal header
     */
    this.setHeader = function (content) {
        $(this.header).html(content);
    };

    /**
     * Set modal content
     * @param {string} content The content of modal content
     */
    this.setContent = function (content) {
        $(this.content).html(content);
    };

    /**
     * Set modal footer
     * @param {string} content The content of modal footer
     */
    this.setFooter = function (content) {
        $(this.footer).html(content);
    };

    this.hidenCloseButton = function () {
        $(this.header).find('button.close').hide();
    };

    this.showCloseButton = function () {
        $(this.header).find('button.close').show();
    };

    this.setTitle = function (title) {
        $(this.header).find('h4.modal-title').remove();
        $(this.header).prepend('<h4 class="modal-title">' + title + '</h4>');
    };

    /**
     * Show loading state in modal
     */
    this.displayLoading = function () {
        this.setContent(this.loadingContent);
        this.setTitle(this.defaults.loadingTitle);
    };

    /**
     * Add button to footer
     * @param string label The label of button
     * @param string classes The class of button
     * @param callable callback the callback when button click
     */
    this.addFooterButton = function (label, type, classes, callback) {
        buttonElm = document.createElement('button');
        buttonElm.setAttribute('type', type === null ? 'button' : type);
        buttonElm.setAttribute('class', classes === null ? 'btn btn-primary' : classes);
        buttonElm.innerHTML = label;
        var instance = this;
        $(this.footer).append(buttonElm);
        if (callback !== null) {
            $(buttonElm).click(function (event) {
                callback.call(instance, this, event);
            });
        }
    };

    /**
     * Send ajax request and wraper response to modal
     * @param {string} url The url of request
     * @param {string} method The method of request
     * @param {object}data of request
     */
    this.doRemote = function (url, method, data, operatos, noOpen) {
        var instance = this;
        $.ajax({
            url: url,
            method: method,
            data: data,
            async: false,
            beforeSend: function () {
                if (noOpen !== undefined && noOpen == 'no') {

                } else {
                    beforeRemoteRequest.call(instance);
                }
            },
            error: function (response) {
                errorRemoteResponse.call(instance, response);
            },
            success: function (response) {
                successRemoteResponse.call(instance, response);
            },
            contentType: false,
            cache: false,
            processData: false
        });
    };

    this.openData = function (response, status) {
        var instance = this;
        beforeRemoteRequest.call(instance);
        successRemoteResponse.call(instance, response);
    }

    /**
     * Before send request process
     * - Ensure clear and show modal
     * - Show loading state in modal
     */
    function beforeRemoteRequest() {
        this.show();
        this.displayLoading();
    }


    /**
     * When remote sends error response
     * @param {string} response
     */
    function errorRemoteResponse(response) {
        this.setTitle(response.status + response.statusText);
        this.setContent(response.responseText);
        this.addFooterButton('Close', 'button', 'btn btn-default', function (button, event) {
            this.hide();
        })
    }

    /**
     * When remote sends success response
     * @param {string} response
     */
    function successRemoteResponse(response) {

        // Reload datatable if response contain forceReload field
        if (response.forceReload !== undefined && response.forceReload) {
            if (response.forceReload == 'true') {
                // Backwards compatible reload of fixed crud-datatable-pjax
                $.pjax.reload({ container: '#crud-datatable-pjax' });
            } else {
                try {
                    const containers = JSON.parse(response.forceReload);
                    containers.forEach((container) => {
                        console.error(container);
                        $.pjax.reload({ container: container, async: false });
                    })
                } catch (e) {
                    $.pjax.reload({ container: response.forceReload });
                }
            }
        }

        // Close modal if response contains forceClose field
        if (response.forceClose !== undefined && response.forceClose) {
            this.hide();
            return;
        }

        if (response.size !== undefined) {
            this.setSize(response.size);
        } else {
            this.setSize('normal');
        }

        if (response.title !== undefined) {
            var content = response.title;
            this.setTitle(content);
        }

        if (response.content !== undefined)
            this.setContent(response.content);

        if (response.footer !== undefined)
            this.setFooter(response.footer);

        if ($(this.content).find("form")[0] !== undefined) {
            console.log($(this.header).find('[type="submit"]')[0]);
            this.setupFormSubmit(
                $(this.content).find("form")[0],
                $(this.footer).find('[type="submit"]')[0],
                $(this.header).find('[type="submit"]')[0]
            );
        }
    }

    /**
     * Prepare submit button when modal has form
     * @param {string} modalForm
     * @param {object} modalFormSubmitBtn
     */
    this.setupFormSubmit = function (modalForm, modalFormSubmitBtn, modalHeaderFormSubmitBtn) {

        if (modalFormSubmitBtn === undefined && modalHeaderFormSubmitBtn === undefined) {
            // If submit button not found throw warning message
            console.warn('Modal has form but does not have a submit button');
        } else {
            var instance = this;
            console.log(modalHeaderFormSubmitBtn);
            // Submit form when user clicks submit button
            $(modalFormSubmitBtn).click(function (e) {
                var data;

                // Test if browser supports FormData which handles uploads
                if (window.FormData) {
                    data = new FormData($(modalForm)[0]);
                } else {
                    // Fallback to serialize
                    data = $(modalForm).serializeArray();
                }

                instance.doRemote(
                    $(modalForm).attr('action'),
                    $(modalForm).hasAttr('method') ? $(modalForm).attr('method') : 'GET',
                    data
                );
            });
            $(modalHeaderFormSubmitBtn).click(function (e) {
                var data;

                // Test if browser supports FormData which handles uploads
                if (window.FormData) {
                    data = new FormData($(modalForm)[0]);
                } else {
                    // Fallback to serialize
                    data = $(modalForm).serializeArray();
                }

                instance.doRemote(
                    $(modalForm).attr('action'),
                    $(modalForm).hasAttr('method') ? $(modalForm).attr('method') : 'GET',
                    data
                );
            });
        }
    };

    this.confirmModal = function (title, message, okLabel, cancelLabel, size, dataUrl, dataRequestMethod, selectedIds, operators) {
        this.show();
        this.setSize(size);

        if (title !== undefined) {
            this.setTitle(title);
        }
        // Add form for user input if required
        this.setContent('<form id="ModalRemoteConfirmForm">' + message);

        var instance = this;
        this.addFooterButton(
            okLabel === undefined ? this.defaults.okLabel : okLabel,
            'submit',
            'btn btn-primary',
            function (e) {
                var data;

                // Test if browser supports FormData which handles uploads
                if (window.FormData) {
                    data = new FormData($('#ModalRemoteConfirmForm')[0]);
                    if (typeof selectedIds !== 'undefined' && selectedIds)
                        data.append('pks', selectedIds.join());
                    if (typeof operators !== 'undefined' && operators)
                        data.append('operator', operators);
                } else {
                    // Fallback to serialize
                    data = $('#ModalRemoteConfirmForm');
                    if (typeof selectedIds !== 'undefined' && selectedIds)
                        data.pks = selectedIds;
                    if (typeof operators !== 'undefined' && operators)
                        data.operator = operators;
                    data = data.serializeArray();
                }

                instance.doRemote(
                    dataUrl,
                    dataRequestMethod,
                    data
                );
            }
        );

        this.addFooterButton(
            cancelLabel === undefined ? this.defaults.cancelLabel : cancelLabel,
            'button',
            'btn btn-default pull-left',
            function (e) {
                this.hide();
            }
        );

    }
    this.open = function (elm, bulkData, operators) {
        if ($(elm).hasAttr('data-confirm-title') || $(elm).hasAttr('data-confirm-message')) {
            this.confirmModal(
                $(elm).attr('data-confirm-title'),
                $(elm).attr('data-confirm-message'),
                $(elm).attr('data-confirm-ok'),
                $(elm).attr('data-confirm-cancel'),
                $(elm).hasAttr('data-modal-size') ? $(elm).attr('data-modal-size') : 'normal',
                $(elm).hasAttr('href') ? $(elm).attr('href') : $(elm).attr('data-url'),
                $(elm).hasAttr('data-request-method') ? $(elm).attr('data-request-method') : 'GET',
                bulkData, operators
            )
        } else {
            this.doRemote(
                $(elm).hasAttr('href') ? $(elm).attr('href') : $(elm).attr('data-url'),
                $(elm).hasAttr('data-request-method') ? $(elm).attr('data-request-method') : 'GET',
                bulkData, operators, $(elm).hasAttr('not-open') ? $(elm).attr('not-open') : ''
            );
        }
    }
}
$(document).on('click', '.plus.ff-orm', function (e) {
    var setData = 0;
    var setIndex = 0;
    var param = $(this).data('param');
    $('.' + param + '.got-data').each(function (index, prop) {
        setData = index + 1;
        setIndex = index;
    });
    var inner = '<div class="row ' + param + ' ' + param + '-' + setData + ' got-data" data-set="' + setData + '"><div class="col-md-6"><input type="text" name="productMeta[' + param + '][' + setData + '][1]" value="" class="form-control"></div><div class="col-md-6"><input type="text" name="productMeta[' + param + '][' + setData + '][2]" value="" class="form-control"></div></div>'
    $('.' + param + '-' + setIndex + '.got-data').after(inner);
})