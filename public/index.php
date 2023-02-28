<?php

    require '../vendor/autoload.php';
    
    $app = new \Quiz\Boot();
    $app->init();
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
  </head>
  <body>
    <form method="POST" action="index.php">
        <input type="hidden" name="category-id" value="<?php echo($app->getCurrentCategory()->getId()); ?>">
    <div class="container" id="app">
        <div class="page-header">
            <h2><?php echo($app->getCurrentCategory()->getTitle()); ?></h2>
        </div>
            <?php foreach($app->getCurrentCategory()->getQuestions() as $question) { ?>
                <div class="panel panel-default" id="question-<?php echo($question->getId()); ?>">
                    <div class="panel-heading">
                      <h3 class="panel-title"><?php echo($question->getTitle()); ?></h3>
                    </div>
                    <?php if($question->isSingleType()) { ?>
                    <div class="panel-body">
                        <?php
                            $answers = $question->getAnswers();
                            shuffle($answers);
                        foreach($answers as $answer) { ?>
                          <div class="radio">
                            <label>
                              <input
                                  type="radio"
                                  name="question-<?php echo($question->getId()); ?>"
                                  value="<?php echo($answer->isCorrect() ? 'true': 'false'); ?>"
                              >
                              <?php echo($answer->getTitle()); ?>
                            </label>
                          </div>
                          <?php } ?>
                        <div class="alert" role="alert" style="display: none">

                        </div>
                        <?php if ($question->getHint()) { ?>
                            <div><b>Hint:</b> <a href="<?php echo($question->getHint()); ?>" target="_blank"><?php echo($question->getHint()); ?></a></div>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-4">
                <?php if($app->getCurrentCategory()->getId() > 1) { ?>
                    <button type="submit" name="previous" class="btn btn-default">Previous</button>
                <?php } ?>
                <?php if($app->getCurrentCategory()->getId() < $app->getTotalCategories()) { ?>
                    <button type="submit" name="next" id="next" class="btn btn-primary">Next</button>
                <?php } ?>
                <button type="button" id="validate" class="btn btn-success">Validate</button>
            </div>
        </div>
        <br/>
    </div>
            </form>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
  <script>
      $(function() {
          $( "#validate").on( "click", function() {

              let questions = $("div[id^='question-']");

              let isCorrect = false;
              questions.each(
                   (index, elem) => {
                      let options = $(elem).find("input");
                      isCorrect = false;
                      options.each(
                          (key, radioElem)  => {
                              if(radioElem.value === 'true' && radioElem.checked === true) {
                                  isCorrect = true;
                              }
                          }
                      );

                      if(isCorrect) {
                          $(elem).find(".alert").removeClass("alert-danger").addClass("alert-success").html('Correct').show();
                      } else {
                          $(elem).find(".alert").removeClass("alert-success").addClass("alert-danger").html('Incorrect').show();
                      }
                  }
              );
          });
      });
  </script>
  </body>
</html>
