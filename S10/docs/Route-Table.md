# Route Table

| HTTP | URL | Controller@Action | Purpose |
|---|---|---|---|
| GET | /requests | RequestController@index | Display all requests |
| GET | /requests/create | RequestController@create | Show the create request form |
| POST | /requests | RequestController@store | Save a new request |
| GET | /requests/{id} | RequestController@show | Show request details |
| POST | /requests/{id}/status | RequestController@updateStatus | Update the request status |
| GET | /staff/requests | RequestController@staffIndex | Display staff view of requests |
