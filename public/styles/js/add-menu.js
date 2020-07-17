$("#accordion").accordionjs();

var itemTemplate = document.getElementById('menu-item').innerHTML;
var updateOutput = function(e) {
    var list   = e.length ? e : $(e.target),
        output = list.data('output');
    if (window.JSON) {
        output.val(window.JSON.stringify(list.nestable('serialize')));
    } else {
        output.val('JSON browser support required for this demo.');
    }
};

function buildItem(item) {
    let children = "";
    if (item.children) {
        children += "<ol class='dd-list'>";
        $.each(item.children, function (index, sub) {
            children += buildItem(sub);
        });
        children += "</ol>";
    }

    let html = replace_template(itemTemplate, {
        'id': item.id,
        'content': htmlspecialchars(item.content),
        'url': item.url,
        'new_tab': item.new_tab,
        'object_id': item.object_id,
        'object_type': item.object_type,
        'children': children,
    });

    return html;
}

function buildMenu(dataJson) {
    let output = '';
    $.each(JSON.parse(dataJson), function (index, item) {
        output += buildItem(item);
    });
    return output;
}

var output = buildMenu(dataJson);
$('#dd-empty-placeholder').html(output);

$('#nestable').nestable({
    group: 1,
    includeContent: true,
    scroll: true,
    emptyClass: false,
}).on('change', updateOutput);

updateOutput($('#nestable').data('output', $('#nestable-output')));

function getNewMenuId() {
    return $('.dd-item').length + 1;
}

function htmlspecialchars(str) {
    return str.replace('&', '&amp;').replace('"', '&quot;').replace("'", '&#039;').replace('<', '&lt;').replace('>', '&gt;');
}

$('#accordion').on('submit', '.add-menu-item', function () {
    let formData = $(this).serialize();
    let type = $(this).find('input[name=type]').val();
    let new_id = getNewMenuId();
    let new_tab = 0;
    let btn = $(this).find('button[type=submit]');
    let icon = btn.find('i').attr('class');

    btn.find('i').attr('class', 'fa fa-spinner fa-spin');
    btn.prop("disabled", true);

    if ($(this).find('input[name=open_new_tab]').is(':checked')) {
        new_tab = 1;
    }

    if (type !== "custom") {

        $.ajax({
            type: "POST",
            url: "/admin-cp/menu/get-data",
            dataType: 'json',
            data: formData,
            success: function (result) {
                $.each(result, function (index, item) {
                    let html = replace_template(itemTemplate, {
                        'id': new_id,
                        'content': htmlspecialchars(item.name).trim(),
                        'url': item.url,
                        'new_tab': new_tab,
                        'object_id': item.object_id,
                        'object_type': type,
                        'children': "",
                    });

                    $('ol#dd-empty-placeholder').append(html);
                });

                updateOutput($('#nestable').data('output', $('#nestable-output')));
                btn.find('i').attr('class', icon);
                btn.prop("disabled", false);
            }
        });
    }
    else {

        let title = $(this).find('input[name=title]').val();
        let url = $(this).find('input[name=url]').val();

        if (!title) {
            show_message('Please enter title!', 'error');
            return false;
        }

        let html = replace_template(itemTemplate, {
            'id': new_id,
            'content': htmlspecialchars(title).trim(),
            'url': url,
            'new_tab': new_tab,
            'object_id': "",
            'object_type': type,
            'children': "",
        });

        $('ol#dd-empty-placeholder').append(html);

        updateOutput($('#nestable').data('output', $('#nestable-output')));
    }
    return false;
});