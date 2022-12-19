# Clean Architecture with Symfony 6.1 / ApiPlatform 3.0

## Implementation study of CleanArchitecture through the must elegant way with using PHP Symfony & ApiPlatform

### Introduction
After months of looking at articles on clean architecture implementations, I couldn't find an example implementation that was comprehensive enough or elegant enough (often sloppy or violates the concepts).

This project was launch as lab to study implementation of Clean Architecture in PHP project with using Symfony & ApiPlatform framework.

No need yet lot of features, this is just a workshop for find the most elegant way to realize it.

### Project tree structure
I choose to organize my folders as contexts which contains all layers of clean architecture.

#### Contexts structure
Actually we have a **Messaging** context (manage conversations, messages & conversations participants) and contexts about backoffice which actually container **Users** context, **Workspace** context and **Authentication** context. **Common** context contains notions global.

I think about Authentication context, if he has her place in this structure or should be only implemented into Application or User Interface layer (in Common context).

#### Layers structure
![](./docs/images/flow-clean-architecture.jpg)

##### UserInterface
These are the entry points of the application, it can be a REST API, a Consumer, a CLI Command etc...

##### Application
Represents a border between the entry points managed by the previous layer. (MessageBus: Command & Query)

##### Domain
Most important of all, this layer is the representation of the business, defined the invariants (set of rules engraved in marble) which ensures the consistency of the code with the business and should be readable enough to be understood by a person who knows the business, but without necessarily any background or technical knowledge. Only the Application layer is authorized to manipulate its objects.

##### Infrastructure
This layer is responsible for implementing the abstractions of domain services and repositories by implementing their interfaces. These implementations or concrete classes will be injected via the principle of dependency inversion. This layer makes the link with all the external services (Database, Partner API, File storage, Asynchronous message publication, Send mail, ...)

### Install project

`make install`

### Quality

Actually with too refactorings, I don't think it the time to implement quality tools but will be implemented in futur.

- Writing functional tests with control of OpenAPI specifications
- Add deptrack control to ensure that layers rules dependencies aren't violated.
- Add PHP static analyzer.
- Add workflow to operate check of previous installed tools on each pull request.
