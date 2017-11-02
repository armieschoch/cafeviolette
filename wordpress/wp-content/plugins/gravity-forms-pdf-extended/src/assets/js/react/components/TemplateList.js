import PropTypes from 'prop-types';
import React from 'react'
import { connect } from 'react-redux'

import getTemplates from '../selectors/getTemplates'

import TemplateContainer from './TemplateContainer'
import TemplateListItem from './TemplateListItem'
import TemplateSearch from './TemplateSearch'
import TemplateHeaderTitle from './TemplateHeaderTitle'
import TemplateUploader from './TemplateUploader'

/**
 * The master component for rendering the all PDF templates as a list
 *
 * @package     Gravity PDF
 * @copyright   Copyright (c) 2017, Blue Liquid Designs
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       4.1
 */

/*
 This file is part of Gravity PDF.

 Gravity PDF – Copyright (C) 2017, Blue Liquid Designs

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Found
 */

/**
 * React Component
 *
 * @since 4.1
 */
export class TemplateList extends React.Component {
  /**
   * @since 4.1
   */
  static propTypes = {
    templates: PropTypes.object,
    route: PropTypes.object
  };

  /**
   * @since 4.1
   */
  render () {
    const header = <TemplateHeaderTitle header={this.props.templateHeaderText}/>

    return (
      <TemplateContainer header={header} closeRoute="/">
        <TemplateSearch />
        <div>
          {
            this.props.templates.map((value, index) => {
              return <TemplateListItem
                key={index}
                template={value}
                templateDetailsText={this.props.templateDetailsText}
                activateText={this.props.activateText}/>
            })
          }

          <TemplateUploader
            ajaxUrl={this.props.ajaxUrl}
            ajaxNonce={this.props.ajaxNonce}
            addTemplateText={this.props.addTemplateText}
            genericUploadErrorText={this.props.genericUploadErrorText}
            filenameErrorText={this.props.filenameErrorText}
            filesizeErrorText={this.props.filesizeErrorText}
            installSuccessText={this.props.installSuccessText}
            installUpdatedText={this.props.installUpdatedText}
            templateSuccessfullyInstalledUpdated={this.props.templateSuccessfullyInstalledUpdated}
            templateInstallInstructions={this.props.templateInstallInstructions}
          />

        </div>
      </TemplateContainer>
    )
  }
}

/**
 * Map state to props
 *
 * @param {Object} state The current Redux State
 *
 * @returns {{templates}}
 *
 * @since 4.1
 */
const mapStateToProps = (state) => {
  return {
    templates: getTemplates(state)
  }
}

/**
 * Maps our Redux store to our React component
 *
 * @since 4.1
 */
export default connect(mapStateToProps)(TemplateList)