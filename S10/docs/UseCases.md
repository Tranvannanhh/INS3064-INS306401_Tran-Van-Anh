# Use Cases

## Use Case 1: Submit a Request
- Actor: Student
- Trigger: The student wants to report a campus problem or service need.
- Main Flow:
  1. The student opens the request submission form.
  2. The student enters the request title and description.
  3. The student submits the form.
  4. The system validates the input.
  5. The system creates a new request with status Pending.
- Alternative Flow:
  - If the title or description is empty, the system shows a validation error.
- Success Outcome:
  - A new request is stored successfully.

## Use Case 2: View Request List
- Actor: Student / Staff
- Trigger: The user wants to see available requests.
- Main Flow:
  1. The user opens the request list page.
  2. The system retrieves all request records.
  3. The system displays the list of requests.
- Alternative Flow:
  - If there are no requests, the system displays an empty list message.
- Success Outcome:
  - The user can see all requests in the system.

## Use Case 3: View Request Details
- Actor: Student / Staff
- Trigger: The user selects one request from the list.
- Main Flow:
  1. The user clicks on a request.
  2. The system finds the request by ID.
  3. The system displays the request details, including title, description, and status.
- Alternative Flow:
  - If the request ID does not exist, the system shows an error message.
- Success Outcome:
  - The user can read the full details of the selected request.

## Use Case 4: Update Request Status
- Actor: Staff
- Trigger: The staff member wants to process a request.
- Main Flow:
  1. The staff member opens the request details page.
  2. The staff member selects a new status.
  3. The system validates the status value.
  4. The system updates the request status.
  5. The system saves the updated request.
- Alternative Flow:
  - If the status is invalid, the system rejects the update.
- Success Outcome:
  - The request status changes successfully.
