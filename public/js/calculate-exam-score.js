const $elSelectors = {
    score: {
        forum: '[data-score=forum]',
        attendance: '[data-score=attendance]',
        quiz: '[data-score=quiz]',
        pas: '[data-score=pas]',
        tas: '[data-score=tas]',
        finalScore: '[data-score=final-score]',
        grade: '[data-score=grade]'
    },
    label: {
        forum: '[data-label=forum]',
        attendance: '[data-label=attendance]',
        quiz: '[data-label=quiz]',
        pas: '[data-label=pas]',
        tas: '[data-label=tas]',
        finalScore: '[data-label=final-score]'
    },
};

const helpers = {
    isNumberKey: function(evt) {
        const charCode = (evt.which) ? evt.which : evt.keyCode;
        return !(charCode !== 46 && charCode > 31
            && (charCode < 48 || charCode > 57)) || [190, 37, 39].includes(charCode);
    },
}

const CalculateExamScore = function(selector) {
    this.$ = $(selector);
};

CalculateExamScore.prototype.configure = function() {
    Object.keys($elSelectors.score).forEach(selector =>
        this._configureOnlyNumber($elSelectors.score[selector]));
};

CalculateExamScore.prototype._configureOnlyNumber = function(selector) {
    this.$.find(selector).each((i, item) => {
        const $item = $(item);
        $item.val(0);

        const $helper = $('<small>', {class: 'text-danger'});

        const $next = $item.next();
        if(!$next.is('small') && !$next.data('helper'))
            $helper.insertAfter($item);

        if($item.data('default') !== undefined)
            $item.val($item.data('default'));

        $item.on('keypress keydown keyup', (event) => {

            if($item.attr('max') !== undefined) {
                const max = parseInt($item.attr('max'));
                if(parseInt($item.val()) > max) {
                    $item.addClass('border-danger');
                    $helper.html("Angka tidak boleh melebihi " + max);
                } else {
                    $helper.empty();
                    $item.removeClass('border-danger');
                }
            }

            return helpers.isNumberKey(event);
        });
    });
};

CalculateExamScore.prototype._scoresForum = function() {
    return this.$.find($elSelectors.score.forum).map(function(i, item) {
        const $item = $(item);
        if($item.val() !== '') {
            const countPost = parseInt($item.val());
            if(countPost > 2)
                return 2;

            return countPost;
        }

        return 0;
    }).get();
};

CalculateExamScore.prototype._scoresAttendance = function() {
    return this.$.find($elSelectors.score.attendance).map(function(i, item) {
        const $item = $(item);
        if($item.val() !== '')
            return parseInt($item.val());

        return 0;
    }).get();
};

CalculateExamScore.prototype._scoreForum = function() {
    const posts = this._scoresForum();
    return 100/(posts.length*2) * posts.reduce((a, b) => a + b, 0);
};

CalculateExamScore.prototype._scoreAttendance = function() {
    const attendances = this._scoresAttendance();

    let totalSession = 6;
    if(this.$.find('[data-score=total-attendance]').val() !== '')
        totalSession = parseInt(this.$.find('[data-score=total-attendance]').val());

    return 100/totalSession * attendances.reduce((a, b) => a + b, 0);
};

CalculateExamScore.prototype._scoreDefault = function(selector) {
    return this.$.find(selector).map(function(i, item) {
        const $item = $(item);
        if($item.val() !== '')
            return parseFloat($item.val());

        return 0;
    }).get();
};

CalculateExamScore.prototype._renderForum = function() {
    const scoreForum = this._scoreForum().toFixed(2);

    const $label = this.$.find($elSelectors.label.forum);
    $label.find('[data-note]').html(scoreForum + ' x 10%');
    $label.find('[data-value]').html((scoreForum * 0.1).toFixed(2));
};

CalculateExamScore.prototype._renderAttendance = function() {
    const scoreAttendance = this._scoreAttendance().toFixed(2);

    const $label = this.$.find($elSelectors.label.attendance);
    $label.find('[data-note]').html(scoreAttendance + ' x 10%');
    $label.find('[data-value]').html((scoreAttendance * 0.1).toFixed(2));
};

CalculateExamScore.prototype._renderDefault = function(index, percentage) {
    const scores = this._scoreDefault($elSelectors.score[index]);
    const score = scores.reduce((a, b) => a + b, 0).toFixed(2)/scores.length;

    const $label = this.$.find($elSelectors.label[index]);
    $label.find('[data-note]').html('(' + scores.join(' + ') + ') / ' + scores.length + ' x ' + percentage + '%');
    $label.find('[data-value]').html((score * percentage/100).toFixed(2));
};

CalculateExamScore.prototype._run = function() {
    this._renderForum();
    this._renderAttendance();
    this._renderDefault('quiz', 15);
    this._renderDefault('pas', 20);
    this._renderDefault('tas', 15);

    const scoreForum = this._scoreForum() * 0.1;
    const scoreAttendance = this._scoreAttendance() * 0.1;

    const scoresQuiz = this._scoreDefault($elSelectors.score.quiz);
    const scoreQuiz = scoresQuiz.reduce((a, b) => a + b, 0) / scoresQuiz.length * 0.15;

    const scoresPAS = this._scoreDefault($elSelectors.score.pas);
    const scorePAS = scoresPAS.reduce((a, b) => a + b, 0) / scoresPAS.length * 0.2;

    const scoresTAS = this._scoreDefault($elSelectors.score.tas);
    const scoreTAS = scoresTAS.reduce((a, b) => a + b, 0) / scoresTAS.length * 0.15;

    const totalScore = scoreForum + scoreAttendance + scoreQuiz + scorePAS + scoreTAS;
    this.$.find('[data-label=total-score]').html(totalScore.toFixed(2));

    const $elFinalScore = this.$.find($elSelectors.score.finalScore);
    const $elGradeScore = this.$.find($elSelectors.score.grade);

    let finalScore = 0;
    if($elFinalScore.val() !== '')
        finalScore = parseFloat($elFinalScore.val());

    $elFinalScore.on('keypress keydown keyup', function() {
        const score = parseFloat(this.value);
        const options = $elGradeScore.find('option');

        if(!isNaN(score)) {
            for(let i = 0; i < options.length; i++) {
                const $item = $(options[i]);
                const value = parseInt($item.attr('value'));

                if(score >= value) {
                    $elGradeScore.val(value);
                    break;
                }
            }
        } else $elGradeScore.val(-1);
    });

    $elGradeScore.change(function() {
        $elFinalScore.val(this.value);
    });

    const $result = this.$.find('[data-label=result]');
    const $note = this.$.find('[data-label=note-score]');
    const $noteTotal = this.$.find('[data-label=note-total]');
    const $finalScore = this.$.find('[data-label=final-score]');

    if(finalScore > totalScore) {
        const scoreExam = (finalScore - totalScore) / 0.3;
        $result.empty();

        $result.append(
            $('<div>', {class: 'text-white'}).append(
                $('<div>', {class: 'd-flex align-items-start'}).append(
                    $('<span>').html('='),
                    $('<div>', {class: 'px-1'}).html(
                        finalScore + ' - ( ' + scoreForum + ' + ' + scoreAttendance + ' + ' + scoreQuiz + ' + ' + scorePAS + ' + ' + scoreTAS + ' ) / 30%'
                    )
                )
            ).css({fontSize: 14})
        );

        $result.append(
            $('<div>', {class: 'text-white'}).append(
                $('<div>', {class: 'd-flex align-items-start'}).append(
                    $('<span>').html('='),
                    $('<div>', {class: 'px-1'}).html(
                        finalScore + ' - ' + totalScore.toFixed(2) + ' / 30%'
                    )
                )
            ).css({fontSize: 14})
        );

        $result.append(
            $('<div>', {class: 'text-white'}).append(
                $('<div>', {class: 'd-flex align-items-start'}).append(
                    $('<span>').html('='),
                    $('<div>', {class: 'px-1'}).html(
                        (finalScore - totalScore).toFixed(2) + ' / 30%'
                    )
                )
            ).css({fontSize: 14})
        );

        $result.append(
            $('<div>', {class: 'text-white mb-3'}).append(
                $('<div>', {class: 'd-flex align-items-start'}).append(
                    $('<span>').html('='),
                    $('<div>', {class: 'px-1'}).html(scoreExam.toFixed(2))
                )
            ).css({fontSize: 14})
        );

        $note.html("Jika anda menginginkan nilai akhir " + finalScore + ", nilai UAS yang harus anda dapatkan adalah")
        $finalScore.html(scoreExam.toFixed(2));
        $noteTotal.html("jika anda tidak mengikuti UAS, anda akan mendapatkan nilai <b>" + totalScore.toFixed(2) + "</b>");
    } else {
        $result.empty();
        $note.empty();
        $finalScore.empty();
        $noteTotal.empty();
    }

    setTimeout(() => this._run(), 500);
};

CalculateExamScore.prototype.render = function() {
    this._run();
};
