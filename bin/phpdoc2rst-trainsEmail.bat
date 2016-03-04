set INPUT_FOLDER=c:\repos\git\art
set OUTPUT_FOLDER=c:\repos\git\train-tickets-gateway-doc



@echo ==================================================================
@echo !!! Start creating of RST-documentation for trains-tickets-gateway



call phpdoc2rst.bat process Rr\EmailBundle\Model %INPUT_FOLDER%/src/Rr/EmailBundle/Model -o %INPUT_FOLDER%/src/Rr/EmailBundle/Resources/views/model


@echo !!! Finish
@echo ==================================================================