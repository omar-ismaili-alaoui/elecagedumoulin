$( document ).ready(function(){
    $('.datepicker').datetimepicker({
        format: 'DD/MM/YYYY'
    });
});



function onload(event) {

    var myDataService =  {
        rate:function(rating) {
            return {then:function (callback) {
                    setTimeout(function () {
                        callback((Math.random() * 5));
                    }, 1000);
                }
            }
        }
    }

    var starRatingStep = raterJs( {
        starSize:32,
        //step:0.5,
        element:document.querySelector("#rater-step"),
        rateCallback:function rateCallback(rating, done) {
            this.setRating(rating);
            doneInsert(rating);
            done();
        }
    });

}

function doneInsert(rating){
    $('#comments_rating').val(rating);
}

window.addEventListener("load", onload, false);