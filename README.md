# RestAPIJobPortal

swagger: '2.0'
info:
  version: '1.0'
  title: API Job Portal
  contact: {}
host: 127.0.0.1:8000
basePath: /api/v1.0
securityDefinitions: {}
schemes:
  - http
consumes:
  - application/json
produces:
  - application/json
paths:
  /login:
    post:
      summary: Login as Applicant
      tags:
        - authentication
      operationId: LoginasApplicant
      deprecated: false
      produces:
        - application/json
      parameters:
        - name: Body
          in: body
          required: true
          description: ''
          schema:
            $ref: '#/definitions/LoginasApplicantRequest'
      responses:
        '200':
          description: ''
          headers: {}
      security: []
  /register:
    post:
      summary: Register as Applicant
      tags:
        - authentication
      operationId: RegisterasApplicant
      deprecated: false
      produces:
        - application/json
      parameters:
        - name: Accept
          in: header
          required: true
          type: string
          description: ''
        - name: Body
          in: body
          required: true
          description: ''
          schema:
            $ref: '#/definitions/RegisterasApplicantRequest'
      responses:
        '200':
          description: ''
          headers: {}
      security: []
  /logout:
    get:
      summary: Logout
      tags:
        - authentication
      operationId: Logout
      deprecated: false
      produces:
        - application/json
      parameters: []
      responses:
        '200':
          description: ''
          headers: {}
      security:
        - bearer: []
  /jobs:
    post:
      summary: Store Job
      tags:
        - job
      operationId: StoreJob
      deprecated: false
      produces:
        - application/json
      parameters:
        - name: Accept
          in: header
          required: true
          type: string
          description: ''
        - name: Body
          in: body
          required: true
          description: ''
          schema:
            $ref: '#/definitions/StoreJobRequest'
      responses:
        '200':
          description: ''
          headers: {}
      security:
        - bearer: []
    get:
      summary: Index Job (Get All Data)
      tags:
        - job
      operationId: IndexJob(GetAllData)
      deprecated: false
      produces:
        - application/json
      parameters: []
      responses:
        '200':
          description: ''
          headers: {}
      security: []
  /jobs/front-end-developer:
    get:
      summary: Show Job
      tags:
        - job
      operationId: ShowJob
      deprecated: false
      produces:
        - application/json
      parameters: []
      responses:
        '200':
          description: ''
          headers: {}
      security: []
  /jobs/back-end-developer:
    put:
      summary: Update Job
      tags:
        - job
      operationId: UpdateJob
      deprecated: false
      produces:
        - application/json
      parameters:
        - name: Accept
          in: header
          required: true
          type: string
          description: ''
        - name: Body
          in: body
          required: true
          description: ''
          schema:
            $ref: '#/definitions/UpdateJobRequest'
      responses:
        '200':
          description: ''
          headers: {}
      security:
        - bearer: []
    delete:
      summary: Delete Job
      tags:
        - job
      operationId: DeleteJob
      deprecated: false
      produces:
        - application/json
      parameters: []
      responses:
        '200':
          description: ''
          headers: {}
      security:
        - bearer: []
  /applicants:
    get:
      summary: Index
      tags:
        - applicants
      operationId: Index
      deprecated: false
      produces:
        - application/json
      parameters: []
      responses:
        '200':
          description: ''
          headers: {}
      security:
        - bearer: []
  /applicants/job-title:
    post:
      summary: Send Application
      tags:
        - applicants
      operationId: SendApplication
      deprecated: false
      produces:
        - application/json
      parameters:
        - name: Accept
          in: header
          required: true
          type: string
          description: ''
        - name: Body
          in: body
          required: true
          description: ''
          schema:
            $ref: '#/definitions/SendApplicationRequest'
      responses:
        '200':
          description: ''
          headers: {}
      security:
        - bearer: []
  /companies/job-title:
    get:
      summary: Index
      tags:
        - companies
      operationId: GetIndex
      deprecated: false
      produces:
        - application/json
      parameters: []
      responses:
        '200':
          description: ''
          headers: {}
      security:
        - bearer: []
  /companies/job-title/status/22:
    patch:
      summary: Change Application Status
      tags:
        - companies
      operationId: ChangeApplicationStatus
      deprecated: false
      produces:
        - application/json
      parameters:
        - name: Accept
          in: header
          required: true
          type: string
          description: ''
        - name: Body
          in: body
          required: true
          description: ''
          schema:
            $ref: '#/definitions/ChangeApplicationStatusRequest'
      responses:
        '200':
          description: ''
          headers: {}
      security:
        - bearer: []
definitions:
  LoginasApplicantRequest:
    title: LoginasApplicantRequest
    example:
      email: userexample@gmail.com
      password: '12341234'
    type: object
    properties:
      email:
        type: string
      password:
        type: string
    required:
      - email
      - password
  LoginasCompanyRequest:
    title: LoginasCompanyRequest
    example:
      email: companyexample@gmail.com
      password: '12341234'
    type: object
    properties:
      email:
        type: string
      password:
        type: string
    required:
      - email
      - password
  RegisterasApplicantRequest:
    title: RegisterasApplicantRequest
    example:
      name: user example
      email: userexample@gmail.com
      password: '12341234'
      password_confirmation: '12341234'
    type: object
    properties:
      name:
        type: string
      email:
        type: string
      password:
        type: string
      password_confirmation:
        type: string
    required:
      - name
      - email
      - password
      - password_confirmation
  RegisterasCompanyRequest:
    title: RegisterasCompanyRequest
    example:
      name: company example
      email: companyexample@gmail.com
      password: '12341234'
      password_confirmation: '12341234'
      role: company
    type: object
    properties:
      name:
        type: string
      email:
        type: string
      password:
        type: string
      password_confirmation:
        type: string
      role:
        type: string
    required:
      - name
      - email
      - password
      - password_confirmation
      - role
  StoreJobRequest:
    title: StoreJobRequest
    example:
      location_id: 10
      category_id: 3
      title: Job title
      description: job description
      type: contract
      level: senior
    type: object
    properties:
      location_id:
        type: integer
        format: int32
      category_id:
        type: integer
        format: int32
      title:
        type: string
      description:
        type: string
      type:
        type: string
      level:
        type: string
    required:
      - location_id
      - category_id
      - title
      - description
      - type
      - level
  UpdateJobRequest:
    title: UpdateJobRequest
    example:
      location_id: 2
      category_id: 1
      title: Job Title Update
      description: Job Description Update
      status: open
      type: internship
      level: entry
    type: object
    properties:
      location_id:
        type: integer
        format: int32
      category_id:
        type: integer
        format: int32
      title:
        type: string
      description:
        type: string
      status:
        type: string
      type:
        type: string
      level:
        type: string
    required:
      - location_id
      - category_id
      - title
      - description
      - status
      - type
      - level
  SendApplicationRequest:
    title: SendApplicationRequest
    example:
      attachment: ini attachment untuk melamar
    type: object
    properties:
      attachment:
        type: string
    required:
      - attachment
  ChangeApplicationStatusRequest:
    title: ChangeApplicationStatusRequest
    example:
      status: hired
    type: object
    properties:
      status:
        type: string
    required:
      - status
security: []
tags:
  - name: authentication
  - name: job
  - name: applicants
  - name: companies
