function populate(professionals) {
    let options = '';

    for (let i = 0; i < professionals.length; i++){
        options += '<option value="'+ professionals[i].id + '">' + professionals[i].name + '</option>';
    }

    return options;
}

function move(direction) {
    let selected = $('input[name=selected]:checked');

    if(selected.length != 0) {
        let parent = $(selected).parent().parent();

        let parentSibling = '';

        if(direction == 'up') {
            parentSibling = $(parent).prev();

            if(parentSibling.length != 0) {
                parent.insertBefore(parentSibling);
            }
        }
            
        if(direction == 'down') {
            parentSibling = $(parent).next();

            if(parentSibling.length != 0) {
                parent.insertAfter(parentSibling);
            }   
        }
    }
}

function add(options) {
    let role = getRoleClass(options);

    $('#roles').append(role);
}

function addAfter(target, options) {
    let role = getRoleClass(options);

    $(target).parent().parent().after(role);
}

function getRoleClass(options) {
    return '<tr class="role"> <td class="align-middle"> <input type="radio" name="selected" class="selected" tabindex="-1"> </td><td class="character"> <input type="text" class="form-control" name="character[]" value="" required> </td><td class="pro"> <select class="form-control professional" name="professional[]"> <option value=""></option> ' + options + '</select> </td><td> <input type="text" class="form-control" name="group[]" value=""> </td><td class="text-center align-middle remover" style="width: 4.5rem"> <button type="button" class="btn btn-xs btn-danger remove action" tabindex="-1"> <i class="fa fa-trash"></i> </button> <button type="button" class="btn btn-xs btn-success add action" tabindex="-1"> <i class="fa fa-plus"></i> </button> </td></tr>';
}

function remove(target) {
    let parent = $(target).parent().parent();

    if(parent.parent().find('.remove').length == 1)
        return;

    if($('#lock').is(':checked')) {
        if(confirm('Tem certeza que deseja apagar?')) {
            parent.remove();
        }
    } else {
        parent.remove();
    }
}


