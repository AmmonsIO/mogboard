import Modals from "./Modals";
import Popup from "./Popup";
import ButtonLoading from "./ButtonLoading";

class ProductAlerts
{
    constructor()
    {
        this.uiForm             = $('.create_alert_form');
        this.uiModal            = $('.alert_modal');
        this.uiModalButton      = $('.btn_create_alert');
        this.uiInfoModal        = $('.alert_info');
        this.uiInfoModalButton  = $('.btn_alert_info');
    }

    watch()
    {
        Modals.add(this.uiModal, this.uiModalButton);
        Modals.add(this.uiInfoModal, this.uiInfoModalButton);

        // on submitting a new
        this.uiForm.on('submit', event => {
            event.preventDefault();

            const payload = {
                itemId: this.uiForm.find('#alert_item_id').val().trim(),
                name:   this.uiForm.find('#alert_name').val().trim(),
                option: this.uiForm.find('#alert_option').val().trim(),
                value:  this.uiForm.find('#alert_value').val().trim(),
                nq:     this.uiForm.find('#alert_nq').prop('checked'),
                hq:     this.uiForm.find('#alert_hq').prop('checked'),
                dc:     this.uiForm.find('#alert_dc').prop('checked'),
                email:  this.uiForm.find('#alert_notify_email').prop('checked'),
                discord:this.uiForm.find('#alert_notify_discord').prop('checked'),
            };

            this.createItemAlert(payload);
        });
    }

    createItemAlert(payload)
    {
        // quick dummy check
        const valueIsNumber = !isNaN(parseFloat(payload.value)) && isFinite(payload.value);
        if (valueIsNumber === false) {
            Popup.warning('Invalid Alert','The alert Condition Value is not a valid number.');
            return;
        }

        const $btn = this.uiForm.find('button.btn_create_alert');
        ButtonLoading.start($btn);

        // send request
        $.ajax({
            url: mog.url_create_alert,
            type: "POST",
            dataType: "json",
            data: JSON.stringify(payload),
            contentType: "application/json",
            success: response => {
                ButtonLoading.finish($btn);

                // if alert ok
                if (response.ok) {
                    Modals.close(this.uiModal);
                    Popup.success('Alert Created','Information on this alert will appear on the homepage!');
                    return;
                }

                // error
                Popup.success('Error',response.message);
            },
            error: (a,b,c) => {
                Popup.success('Error 37','Could not create alert. ');
                console.log('--- ERROR ---');
                console.log(a,b,c)
            }
        });
    }
}

export default new ProductAlerts;
