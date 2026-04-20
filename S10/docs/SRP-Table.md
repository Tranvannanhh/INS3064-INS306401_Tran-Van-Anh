# Class Responsibility Table (SRP)

| Class Name | Responsibility | Reason to Change |
|---|---|---|
| Request | Stores request data such as id, title, description, and status | Request data fields change |
| RequestRepository | Reads and writes request data from storage | Storage method changes |
| RequestService | Applies business rules such as creating requests and changing statuses | Business rules change |
| RequestValidator | Validates user input and status values | Validation rules change |
| RequestController | Receives user actions and coordinates service calls and views | Route or action flow changes |
| ViewRenderer | Loads a view file and passes data to it | Rendering mechanism changes |
