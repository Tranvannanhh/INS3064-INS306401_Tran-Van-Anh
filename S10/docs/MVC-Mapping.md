# MVC Mapping Table

| Item | MVC Layer | Why? |
|---|---|---|
| Request | Model | Represents request data |
| RequestRepository | Model | Handles data access |
| RequestService | Model | Handles business rules |
| RequestValidator | Model | Handles validation logic |
| RequestController@index | Controller | Controls the request list flow |
| RequestController@show | Controller | Controls the request detail flow |
| RequestController@store | Controller | Controls request creation |
| RequestController@updateStatus | Controller | Controls status updates |
| requests/index.php | View | Displays the request list |
| requests/show.php | View | Displays request details |
| requests/create.php | View | Displays the form to create a request |
