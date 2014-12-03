Feature: WebitSoapApiBundle - Service container extension
  In order to bootstrap SOAP-API library
  As a developer
  I want register SOAP-API library services in service container

  Scenario: Loading extension
    When application is up
    Then there should be following services in container:
    """
    webit_soap_api.soap_client_factory.default, webit_soap_api.soap_client_factory,
    webit_soap_api.executor_factory, webit_soap_api.input_normalizer.serializer_factory,
    webit_soap_api.result_type_map.factory, webit_soap_api.hydrator.serializer,
    webit_soap_api.hydrator
    """
