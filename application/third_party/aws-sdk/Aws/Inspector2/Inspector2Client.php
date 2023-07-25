<?php
namespace Aws\Inspector2;

use Aws\AwsClient;

/**
 * This client is used to interact with the **Inspector2** service.
 * @method \Aws\Result associateMember(array $args = [])
 * @method \GuzzleHttp\Promise\Promise associateMemberAsync(array $args = [])
 * @method \Aws\Result batchGetAccountStatus(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchGetAccountStatusAsync(array $args = [])
 * @method \Aws\Result batchGetCodeSnippet(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchGetCodeSnippetAsync(array $args = [])
 * @method \Aws\Result batchGetFreeTrialInfo(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchGetFreeTrialInfoAsync(array $args = [])
 * @method \Aws\Result batchGetMemberEc2DeepInspectionStatus(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchGetMemberEc2DeepInspectionStatusAsync(array $args = [])
 * @method \Aws\Result batchUpdateMemberEc2DeepInspectionStatus(array $args = [])
 * @method \GuzzleHttp\Promise\Promise batchUpdateMemberEc2DeepInspectionStatusAsync(array $args = [])
 * @method \Aws\Result cancelFindingsReport(array $args = [])
 * @method \GuzzleHttp\Promise\Promise cancelFindingsReportAsync(array $args = [])
 * @method \Aws\Result cancelSbomExport(array $args = [])
 * @method \GuzzleHttp\Promise\Promise cancelSbomExportAsync(array $args = [])
 * @method \Aws\Result createFilter(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createFilterAsync(array $args = [])
 * @method \Aws\Result createFindingsReport(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createFindingsReportAsync(array $args = [])
 * @method \Aws\Result createSbomExport(array $args = [])
 * @method \GuzzleHttp\Promise\Promise createSbomExportAsync(array $args = [])
 * @method \Aws\Result deleteFilter(array $args = [])
 * @method \GuzzleHttp\Promise\Promise deleteFilterAsync(array $args = [])
 * @method \Aws\Result describeOrganizationConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise describeOrganizationConfigurationAsync(array $args = [])
 * @method \Aws\Result disable(array $args = [])
 * @method \GuzzleHttp\Promise\Promise disableAsync(array $args = [])
 * @method \Aws\Result disableDelegatedAdminAccount(array $args = [])
 * @method \GuzzleHttp\Promise\Promise disableDelegatedAdminAccountAsync(array $args = [])
 * @method \Aws\Result disassociateMember(array $args = [])
 * @method \GuzzleHttp\Promise\Promise disassociateMemberAsync(array $args = [])
 * @method \Aws\Result enable(array $args = [])
 * @method \GuzzleHttp\Promise\Promise enableAsync(array $args = [])
 * @method \Aws\Result enableDelegatedAdminAccount(array $args = [])
 * @method \GuzzleHttp\Promise\Promise enableDelegatedAdminAccountAsync(array $args = [])
 * @method \Aws\Result getConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getConfigurationAsync(array $args = [])
 * @method \Aws\Result getDelegatedAdminAccount(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getDelegatedAdminAccountAsync(array $args = [])
 * @method \Aws\Result getEc2DeepInspectionConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getEc2DeepInspectionConfigurationAsync(array $args = [])
 * @method \Aws\Result getEncryptionKey(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getEncryptionKeyAsync(array $args = [])
 * @method \Aws\Result getFindingsReportStatus(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getFindingsReportStatusAsync(array $args = [])
 * @method \Aws\Result getMember(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getMemberAsync(array $args = [])
 * @method \Aws\Result getSbomExport(array $args = [])
 * @method \GuzzleHttp\Promise\Promise getSbomExportAsync(array $args = [])
 * @method \Aws\Result listAccountPermissions(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listAccountPermissionsAsync(array $args = [])
 * @method \Aws\Result listCoverage(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listCoverageAsync(array $args = [])
 * @method \Aws\Result listCoverageStatistics(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listCoverageStatisticsAsync(array $args = [])
 * @method \Aws\Result listDelegatedAdminAccounts(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listDelegatedAdminAccountsAsync(array $args = [])
 * @method \Aws\Result listFilters(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listFiltersAsync(array $args = [])
 * @method \Aws\Result listFindingAggregations(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listFindingAggregationsAsync(array $args = [])
 * @method \Aws\Result listFindings(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listFindingsAsync(array $args = [])
 * @method \Aws\Result listMembers(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listMembersAsync(array $args = [])
 * @method \Aws\Result listTagsForResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listTagsForResourceAsync(array $args = [])
 * @method \Aws\Result listUsageTotals(array $args = [])
 * @method \GuzzleHttp\Promise\Promise listUsageTotalsAsync(array $args = [])
 * @method \Aws\Result resetEncryptionKey(array $args = [])
 * @method \GuzzleHttp\Promise\Promise resetEncryptionKeyAsync(array $args = [])
 * @method \Aws\Result searchVulnerabilities(array $args = [])
 * @method \GuzzleHttp\Promise\Promise searchVulnerabilitiesAsync(array $args = [])
 * @method \Aws\Result tagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise tagResourceAsync(array $args = [])
 * @method \Aws\Result untagResource(array $args = [])
 * @method \GuzzleHttp\Promise\Promise untagResourceAsync(array $args = [])
 * @method \Aws\Result updateConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateConfigurationAsync(array $args = [])
 * @method \Aws\Result updateEc2DeepInspectionConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateEc2DeepInspectionConfigurationAsync(array $args = [])
 * @method \Aws\Result updateEncryptionKey(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateEncryptionKeyAsync(array $args = [])
 * @method \Aws\Result updateFilter(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateFilterAsync(array $args = [])
 * @method \Aws\Result updateOrgEc2DeepInspectionConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateOrgEc2DeepInspectionConfigurationAsync(array $args = [])
 * @method \Aws\Result updateOrganizationConfiguration(array $args = [])
 * @method \GuzzleHttp\Promise\Promise updateOrganizationConfigurationAsync(array $args = [])
 */
class Inspector2Client extends AwsClient {}
