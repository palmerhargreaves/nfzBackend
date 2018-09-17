/**
 * Created by kostet on 12.09.2018.
 */

StatisticBySections = function (config) {

    $.extend(this, config);
}

StatisticBySections.prototype = {
    start: function() {
        this.initEvents();

        return this;
    },

    initEvents: function() {
        $(document).on("click", ".modal-trigger", $.proxy(this.onLoadModalContent, this));
        $(document).on("click", ".js-add-new-field", $.proxy(this.onSubmitAddNewField, this));
        $(document).on("click", ".js-add-new-section", $.proxy(this.onSubmitAddNewSection, this));

        $(document).on("input, change", ".section-item", $.proxy(this.onSectionDataChanged, this));
        $(document).on("input, change", ".field-item", $.proxy(this.onFieldDataChanged, this));

        $(document).on("click", ".js-btn-save-field, .js-btn-save-section", $.proxy(this.onSaveFieldData, this));

        $(document).on("click", "#js-save-calc-value", $.proxy(this.onSaveCalculatedFieldData, this));
        $(document).on("change", ".ch-calc-field", $.proxy(this.onCalculatedFieldChanged, this));

        $(document).on("click", ".collapsible-header", $.proxy(this.onExpandSectionData, this));

        this.initElements();
    },

    initElements: function() {
        var dragger = tableDragger(document.querySelector(".sortable-sections-list"), {
            mode: "row",
        });

        dragger.on("drop", function(from, to, el) {
            var table = $(el), sections = [];

            table.find("tbody > tr").each(function(ind, item) {
                sections.push($(item).data("id"));
            });

            $.post(table.data("url"), {
                activity: table.data("activity-id"),
                sections: sections
            }, function(result) {
                Materialize.toast("Сортировка выполнена успешно.", 2500);
            });
        });
    },

    onLoadModalContent: function(event) {
        var element = $(event.currentTarget);

        if (element.data("href") != undefined) {
            $.post(element.data("href"), {}, $.proxy(this.onLoadModalContentResult, this));
        }
    },

    onLoadModalContentResult: function(result) {
        result.parent_container != undefined ? $(".modal-content", $(result.parent_container)).html(result.content) : $(".modal-content").html(result.content);

        $("#checked-calc-field").nestable({
            group: 1
        });
    },

    onSubmitAddNewField: function(event) {
        $("#form-new-field-add").submit();
    },

    onSubmitAddNewSection: function(event) {
        $("#form-new-section-add").submit();
    },

    onFieldDataChanged: function(event) {
        var element = $(event.currentTarget), parent = element.closest("tr");

        $(".btn-save-field" + parent.data("id")).fadeIn();
    },

    onSectionDataChanged: function(event) {
        var element = $(event.currentTarget), parent = element.closest("tr");

        $(".btn-save-section" + parent.data("id")).fadeIn();

        console.log(parent.data("id"));
    },

    onSaveFieldData: function(event) {
        var element = $(event.currentTarget), parent = element.closest("tr"), url = parent.data("url"), data = [];

        parent.find("input,select").each(function(index, item) {
            if ($(item).hasClass("checkbox")) {
                data.push({
                    field : $(item).data("field"),
                    value : $(item).is(":checked") ? 1 : 0
                });
            } else if ($(item).data("field") != undefined) {
                data.push({
                    field : $(item).data("field"),
                    value : $(item).val()
                });
            }
        });

        $.post(url, {
            data: data,
            field_id: parent.data("id")
        }, function(result) {
            Materialize.toast(result.msg, 2500);
        });

        element.fadeOut();
    },

    onSaveCalculatedFieldData: function(event) {
        var element = $(event.currentTarget), items = [];

        $("#checked-calc-field .dd-item").each(function(ind, item) {
            items.push({
                id: $(item).data("id")
            });
        });

        if (items.length < 2) {
            Materialize.toast("Для продолжения необходимо выбрать поля.", 2500);
            return;
        }

        $.post(element.data("url"), {
            data: items,
            field_id: element.data("id"),
            calc_type: $("#field-calc-type").val()
        }, function(result) {
            Materialize.toast(result.msg, 2500);
        });
    },

    onCalculatedFieldChanged: function(event) {
        var checked_calc_fields = this.getCalcCheckedFields(), element = $(event.currentTarget);

        if (element.is(":checked")) {
            $("#checked-calc-field").append("<li class='dd-item' data-id='" + element.data("id") + "'><div class='dd-handle'>" + element.data("name") + "</div></li>");
        } else {
            $("li[data-id='" + element.data("id") + "']").remove();
        }

        checked_calc_fields.length >= 2 ? $("#js-save-calc-value").fadeIn() : $("#js-save-calc-value").fadeOut();
    },

    getCalcCheckedFields: function () {
        var calc_checked_fields = [];

        $(".ch-calc-field").each(function(ind, item) {
            if ($(item).is(":checked")) {
                calc_checked_fields.push({
                    id: $(item).data("id")
                });
            }
        });

        return calc_checked_fields;
    },

    onExpandSectionData: function(event) {
        var table = $(event.currentTarget).data("id") != undefined ? $(event.currentTarget) : $(event.currentTarget).parent();

        if (!table.hasClass("has-sort")) {
            var dragger = tableDragger(document.querySelector(".sortable-list-" + table.data("id")), {
                mode: "row",
            });

            dragger.on("drop", function(from, to, el) {
                var table = $(el), fields = [];

                table.find("tbody > tr").each(function(ind, item) {
                    fields.push($(item).data("id"));
                });

                $.post(table.data("url"), {
                    section: table.data("section-id"),
                    fields: fields
                }, function(result) {
                    Materialize.toast("Сортировка выполнена успешно.", 2500);
                });
            });

            table.addClass("has-sort");
        }
    }
}
