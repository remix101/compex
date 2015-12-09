$(document).ready(function() {
    $('.tree').loadTree();    
});

$.fn.extend({
    editable: function () {
        $(this).each(function (index) {
            console.log(index);
            var $el = $(this),
                $edittextbox = $('<input class="editable-input" type="text"></input>').css('min-width', $el.width()),
                submitChanges = function () {
                    if ($edittextbox.val() !== '') {
                        $el.text($edittextbox.val());
                        $el.show();
                        $el.trigger('editsubmit', [$el.text()]);
                        $(document).unbind('click', submitChanges);
                        $edittextbox.detach();;
                    }
                },
                tempVal;
            $edittextbox.click(function (event) {
                event.stopPropagation();
            });

            $el.dblclick(function (e) {
                tempVal = $el.text();
                $edittextbox.val(tempVal).insertBefore(this)
                    .bind('keypress', function (e) {
                    var code = (e.keyCode ? e.keyCode : e.which);
                    if (code == 13) {
                        submitChanges();
                    }
                }).select();
                $el.hide();
                $(document).click(submitChanges);
            });
        });

        return this;
    }
});

(function($) {
    $.fn.loadTree = function() {
        this.each(function(index) {
            $(this).find('.btsp').remove();
            $(this).find('ul').attr('role', 'tree').find('ul').attr('role', 'group').before('<span class="btsp"><i class="fa fa-plus"><i></span>');
            $(this).find('span').on('dblclick', function(e){
                $(this).editable();
            });
            $(this).find('a').on('dblclick', function(e){
                $(this).editable();
                return false;
            });
            $(this).find('li:has(ul)').addClass('parent_li').attr('role', 'treeitem').find(' > span').attr('title', 'Collapse this branch').on('click', function (e) {
                var children = $(this).parent('li.parent_li').find(' > ul');
                if (children.is(':visible')) {
                    children.hide('fast');
                    $(this).attr('title', 'Expand this branch').find(' > i').addClass('fa-plus').removeClass('fa-minus');
                }
                else {
                    children.show('fast');
                    $(this).attr('title', 'Collapse this branch').find(' > i').addClass('fa-minus').removeClass('fa-plus');
                }
                e.stopPropagation();
            });
        })
    },
        $.fn.addNode = function(t, i) {        
        $(this).find('ul > li').eq(i).each(function(){
            var root = $(this).closest('ul').attr('role') == 'tree';
            $(this).after('<li>'+' <span>' +t+'</span>'+(root ? '<a> #</a><ul><li><span> Double click to edit</span><a> #</a></li></ul>' : '<a> #</a>')+'</li>');
        });
        $(this).loadTree();
    },
        $.fn.deleteNode = function(i) {
        $(this).find('ul > li').eq(i).remove();;
    }

})(jQuery);
