set INPUT_FOLDER=c:\repos\git\trains
set OUTPUT_FOLDER=c:\repos\git\train-tickets-gateway-doc



@echo ==================================================================
@echo !!! Start creating of RST-documentation for trains-tickets-gateway



call phpdoc2rst.bat process Art\Controllers\trains\xml %INPUT_FOLDER%/src/Art/Controllers/trains/xml -o %OUTPUT_FOLDER%/controllers/ -e methods

call phpdoc2rst.bat process Art\Models\XmlGateway %INPUT_FOLDER%/src/Art/Models/XmlGateway -o %OUTPUT_FOLDER%/models/response/ -x Art\Models\XmlGateway\Input

call phpdoc2rst.bat process Art\Models\Reports %INPUT_FOLDER%/src/Art/Models/Reports -o %OUTPUT_FOLDER%/models/reports/tickets/

call phpdoc2rst.bat process Art\Models\XmlGateway\Input %INPUT_FOLDER%/src/Art/Models/XmlGateway/Input -o %OUTPUT_FOLDER%/models/request/

call phpdoc2rst.bat process Art\Exceptions\XmlGateway %INPUT_FOLDER%/src/Art/Exceptions/XmlGateway -o %OUTPUT_FOLDER%/ -e exceptions


del "%OUTPUT_FOLDER%\models\response\TrainRequest.rst"

del "%OUTPUT_FOLDER%\models\response\ScheduleRequest.rst"

del "%OUTPUT_FOLDER%\controllers\DefaultXmlController.rst"

del "%OUTPUT_FOLDER%\controllers\TestInformationController.rst"

del "%OUTPUT_FOLDER%\controllers\TestTicketsController.rst"

del "%OUTPUT_FOLDER%\controllers\YouAreNotAuthenticatedController.rst"


goto jp1


copy /Y "../tmp/Art/Controllers/trains/xml" "%OUTPUT_FOLDER%/controllers"

copy /Y "../tmp/Art/Models/XmlGateway" "%OUTPUT_FOLDER%/models/response"

copy /Y "../tmp/Art/Models/Reports/Tickets" "%OUTPUT_FOLDER%/models/reports/tickets"

copy /Y "../tmp/Art/Models/XmlGateway/Input" "%OUTPUT_FOLDER%/models/request"

copy "..\tmp\errors.rst" "%OUTPUT_FOLDER%"


:jp1


@echo !!! Finish
@echo ==================================================================